<?php

namespace Cloudflare\Tests\Endpoints\Zones;

use Cloudflare\Tests\Concerns\InteractsWithMockClient;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\Test;

class RateLimitsTest extends TestCase
{
    use InteractsWithMockClient;

    #[Test]
    public function shouldListRateLimits()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode([
                'success' => true,
                'result' => [
                    ['id' => 'rate_limit_id'],
                ],
            ])),
        ]);

        $response = $client->zones()->rateLimits()->list('zone_id');

        $this->assertTrue($response->successful());
        $this->assertSame('rate_limit_id', $response->json('result.0.id'));

        $this->assertSame('GET', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/zones/zone_id/rate_limits', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldGetRateLimitDetails()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode([
                'success' => true,
                'result' => [
                    'id' => 'rate_limit_id',
                ],
            ])),
        ]);

        $response = $client->zones()->rateLimits()->details('zone_id', 'rate_limit_id');

        $this->assertTrue($response->successful());
        $this->assertSame('rate_limit_id', $response->json('result.id'));

        $this->assertSame('GET', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/zones/zone_id/rate_limits/rate_limit_id', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldCreateRateLimit()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode([
                'success' => true,
                'result' => [
                    'id' => 'rate_limit_id',
                ],
            ])),
        ]);

        $response = $client->zones()->rateLimits()->create('zone_id', [
            'threshold' => 100,
            'period' => 60,
            'match' => [
                'request' => ['url' => '*.example.com/*'],
            ],
            'action' => ['mode' => 'simulate'],
        ]);

        $this->assertTrue($response->successful());
        $this->assertSame('rate_limit_id', $response->json('result.id'));

        $this->assertSame('POST', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/zones/zone_id/rate_limits', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldUpdateRateLimit()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode([
                'success' => true,
                'result' => [
                    'id' => 'rate_limit_id',
                    'threshold' => 200,
                ],
            ])),
        ]);

        $response = $client->zones()->rateLimits()->update('zone_id', 'rate_limit_id', [
            'threshold' => 200,
            'period' => 60,
            'match' => [
                'request' => ['url' => '*.example.com/*'],
            ],
            'action' => ['mode' => 'simulate'],
        ]);

        $this->assertTrue($response->successful());
        $this->assertSame(200, $response->json('result.threshold'));

        $this->assertSame('PUT', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/zones/zone_id/rate_limits/rate_limit_id', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldDeleteRateLimit()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode([
                'success' => true,
                'result' => [
                    'id' => 'rate_limit_id',
                ],
            ])),
        ]);

        $response = $client->zones()->rateLimits()->delete('zone_id', 'rate_limit_id');

        $this->assertTrue($response->successful());

        $this->assertSame('DELETE', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/zones/zone_id/rate_limits/rate_limit_id', $this->lastRequest()->getUri()->getPath());
    }
}
