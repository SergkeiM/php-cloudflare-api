<?php

namespace Cloudflare\Tests\HttpClient;

use Cloudflare\ClientOptions;
use Cloudflare\HttpClient\Exceptions\ConnectionException;
use Cloudflare\HttpClient\Exceptions\NotFoundException;
use Cloudflare\HttpClient\Exceptions\RateLimitException;
use Cloudflare\HttpClient\Retry;
use Cloudflare\Tests\Concerns\InteractsWithMockClient;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\TestWith;
use PHPUnit\Framework\TestCase;

class RetryTest extends TestCase
{
    use InteractsWithMockClient;

    /**
     * `Retry-After: 0` keeps the suite fast while still exercising the retry path.
     */
    private const NO_DELAY = ['Retry-After' => '0'];

    #[TestWith([408])]
    #[TestWith([409])]
    #[TestWith([429])]
    #[TestWith([500])]
    #[TestWith([502])]
    #[TestWith([503])]
    #[Test]
    public function shouldRetryTransientStatusAndSucceed(int $status)
    {
        $client = $this->mockClient([
            new Response($status, self::NO_DELAY, '{}'),
            new Response(200, [], json_encode(['success' => true, 'result' => ['id' => 'zone_id']])),
        ], new ClientOptions(maxRetries: 2));

        $response = $client->zones()->get('zone_id');

        $this->assertTrue($response->successful());
        $this->assertCount(2, $this->requestHistory);
    }

    #[TestWith([400])]
    #[TestWith([401])]
    #[TestWith([403])]
    #[TestWith([404])]
    #[TestWith([422])]
    #[Test]
    public function shouldNotRetryClientErrors(int $status)
    {
        $client = $this->mockClient([
            new Response($status, [], '{}'),
        ], new ClientOptions(maxRetries: 2));

        try {
            $client->zones()->get('zone_id');
        } catch (\Throwable $e) {
            // The mapped exception is asserted elsewhere; here we only care about attempts.
        }

        $this->assertCount(1, $this->requestHistory);
    }

    #[Test]
    public function shouldGiveUpAfterMaxRetriesAndThrow()
    {
        $client = $this->mockClient([
            new Response(429, self::NO_DELAY, '{}'),
            new Response(429, self::NO_DELAY, '{}'),
            new Response(429, self::NO_DELAY, '{}'),
        ], new ClientOptions(maxRetries: 2));

        $this->expectException(RateLimitException::class);

        try {
            $client->zones()->get('zone_id');
        } finally {
            $this->assertCount(3, $this->requestHistory);
        }
    }

    #[Test]
    public function shouldNotRetryWhenDisabled()
    {
        $client = $this->mockClient([
            new Response(429, self::NO_DELAY, '{}'),
        ], new ClientOptions(maxRetries: 0));

        $this->expectException(RateLimitException::class);

        try {
            $client->zones()->get('zone_id');
        } finally {
            $this->assertCount(1, $this->requestHistory);
        }
    }

    #[Test]
    public function shouldRetryConnectionFailures()
    {
        $request = new Request('GET', 'https://api.cloudflare.com/client/v4/zones/zone_id');

        $client = $this->mockClient([
            new ConnectException('Could not resolve host', $request),
            new Response(200, [], json_encode(['success' => true])),
        ], new ClientOptions(maxRetries: 2));

        $this->assertTrue($client->zones()->get('zone_id')->successful());
        $this->assertCount(2, $this->requestHistory);
    }

    #[Test]
    public function shouldGiveUpOnPersistentConnectionFailures()
    {
        $request = new Request('GET', 'https://api.cloudflare.com/client/v4/zones/zone_id');

        $client = $this->mockClient([
            new ConnectException('Could not resolve host', $request),
            new ConnectException('Could not resolve host', $request),
        ], new ClientOptions(maxRetries: 1));

        $this->expectException(ConnectionException::class);

        $client->zones()->get('zone_id');
    }

    #[Test]
    public function shouldRetryWithBackoffWhenNoRetryAfterHeaderIsPresent()
    {
        $client = $this->mockClient([
            new Response(503, [], '{}'),
            new Response(200, [], json_encode(['success' => true])),
        ], new ClientOptions(maxRetries: 1));

        $this->assertTrue($client->zones()->get('zone_id')->successful());
        $this->assertCount(2, $this->requestHistory);
    }

    #[Test]
    public function shouldRetryWritesToo()
    {
        $client = $this->mockClient([
            new Response(429, self::NO_DELAY, '{}'),
            new Response(200, [], json_encode(['success' => true, 'result' => ['id' => 'zone_id']])),
        ], new ClientOptions(maxRetries: 2));

        $response = $client->zones()->create('account_id', 'example.com');

        $this->assertTrue($response->successful());
        $this->assertCount(2, $this->requestHistory);
        $this->assertSame('POST', $this->lastRequest()->getMethod());
    }

    #[Test]
    public function shouldSurfaceTheFinalResponseNotTheRetriedOne()
    {
        $client = $this->mockClient([
            new Response(500, self::NO_DELAY, '{}'),
            new Response(404, [], json_encode(['success' => false])),
        ], new ClientOptions(maxRetries: 2));

        $this->expectException(NotFoundException::class);

        $client->zones()->get('zone_id');
    }

    #[Test]
    public function shouldRunUserMiddlewareOnEveryAttempt()
    {
        $attempts = 0;

        $client = $this->mockClient([
            new Response(429, self::NO_DELAY, '{}'),
            new Response(200, [], json_encode(['success' => true])),
        ], new ClientOptions(
            middlewares: [
                function (callable $handler) use (&$attempts) {
                    return function ($request, array $options) use ($handler, &$attempts) {
                        $attempts++;

                        return $handler($request, $options);
                    };
                },
            ],
            maxRetries: 2,
        ));

        $client->zones()->get('zone_id');

        $this->assertSame(2, $attempts);
    }

    #[Test]
    public function shouldHonourRetryAfterInSeconds()
    {
        $this->assertSame(3000, Retry::delay(1, new Response(429, ['Retry-After' => '3'])));
    }

    #[Test]
    public function shouldHonourRetryAfterAsHttpDate()
    {
        $response = new Response(429, ['Retry-After' => gmdate('D, d M Y H:i:s \G\M\T', time() + 5)]);

        $this->assertEqualsWithDelta(5000, Retry::delay(1, $response), 1000);
    }

    #[Test]
    public function shouldNeverReturnNegativeDelayForPastRetryAfterDate()
    {
        $response = new Response(429, ['Retry-After' => gmdate('D, d M Y H:i:s \G\M\T', time() - 60)]);

        $this->assertSame(0, Retry::delay(1, $response));
    }

    #[Test]
    public function shouldFallBackToBackoffForUnparsableRetryAfter()
    {
        $delay = Retry::delay(1, new Response(429, ['Retry-After' => 'soon-ish']));

        $this->assertGreaterThanOrEqual(0, $delay);
        $this->assertLessThanOrEqual(Retry::BASE_DELAY_MS, $delay);
    }

    #[TestWith([1, Retry::BASE_DELAY_MS])]
    #[TestWith([2, 1000])]
    #[TestWith([3, 2000])]
    #[TestWith([4, 4000])]
    #[Test]
    public function shouldGrowBackoffExponentially(int $attempt, int $ceiling)
    {
        for ($i = 0; $i < 25; $i++) {
            $delay = Retry::delay($attempt);

            $this->assertGreaterThanOrEqual(0, $delay);
            $this->assertLessThanOrEqual($ceiling, $delay);
        }
    }

    #[Test]
    public function shouldCapBackoffAtMaxDelay()
    {
        for ($i = 0; $i < 25; $i++) {
            $this->assertLessThanOrEqual(Retry::MAX_DELAY_MS, Retry::delay(20));
        }
    }

    #[Test]
    public function shouldNotRetryNonConnectionExceptions()
    {
        $this->assertFalse(Retry::shouldRetry(null, new \RuntimeException('boom')));
    }

    #[Test]
    public function shouldNotRetryWithoutResponseOrException()
    {
        $this->assertFalse(Retry::shouldRetry(null, null));
    }
}
