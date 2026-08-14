<?php

namespace Cloudflare\Tests\HttpClient;

use Cloudflare\ClientOptions;
use Cloudflare\Tests\Concerns\InteractsWithMockClient;
use Cloudflare\HttpClient\Exceptions\AuthenticationException;
use Cloudflare\HttpClient\Exceptions\BadRequestException;
use Cloudflare\HttpClient\Exceptions\ConnectionException;
use Cloudflare\HttpClient\Exceptions\InternalServerException;
use Cloudflare\HttpClient\Exceptions\NotFoundException;
use Cloudflare\HttpClient\Exceptions\PermissionDeniedException;
use Cloudflare\HttpClient\Exceptions\RateLimitException;
use Cloudflare\HttpClient\Exceptions\RequestException;
use Cloudflare\HttpClient\Exceptions\UnprocessableEntityException;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\RequestOptions;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\TestWith;
use PHPUnit\Framework\TestCase;

class HttpClientTest extends TestCase
{
    use InteractsWithMockClient;

    #[Test]
    public function shouldExposeGuzzleClient()
    {
        $client = $this->mockClient([]);

        $this->assertInstanceOf(GuzzleClient::class, $client->getHttpClient()->getGuzzleClient());
    }

    #[Test]
    public function shouldExposeOptions()
    {
        $client = $this->mockClient([], new ClientOptions(timeout: 90));

        $this->assertSame(90.0, $client->getOptions()->timeout);
        $this->assertSame($client->getOptions(), $client->getHttpClient()->getOptions());
    }

    #[Test]
    public function shouldDefaultToCloudflareApiBaseUrl()
    {
        $client = $this->mockClient([
            new Response(200, [], '{}'),
        ]);

        $client->zones()->get('zone_id');

        $this->assertSame('https://api.cloudflare.com/client/v4/zones/zone_id', (string) $this->lastRequest()->getUri());
    }

    #[Test]
    public function shouldResolveRequestsAgainstCustomBaseUrl()
    {
        $client = $this->mockClient([
            new Response(200, [], '{}'),
        ], new ClientOptions(baseUrl: 'https://mock.test/api'));

        $client->zones()->get('zone_id');

        $this->assertSame('https://mock.test/api/zones/zone_id', (string) $this->lastRequest()->getUri());
    }

    #[Test]
    public function shouldApplyConfiguredTimeouts()
    {
        $client = $this->mockClient([
            new Response(200, [], '{}'),
        ], new ClientOptions(timeout: 90, connectTimeout: 3));

        $client->zones()->get('zone_id');

        $options = $this->lastRequestOptions();

        $this->assertSame(90.0, $options[RequestOptions::TIMEOUT]);
        $this->assertSame(3.0, $options[RequestOptions::CONNECT_TIMEOUT]);
    }

    #[Test]
    public function shouldSendDefaultHeaders()
    {
        $client = $this->mockClient([
            new Response(200, [], '{}'),
        ]);

        $client->zones()->get('zone_id');

        $this->assertSame('Bearer token', $this->lastRequest()->getHeaderLine('Authorization'));
        $this->assertSame(ClientOptions::DEFAULT_USER_AGENT, $this->lastRequest()->getHeaderLine('User-Agent'));
    }

    #[Test]
    public function shouldSendCustomHeaders()
    {
        $client = $this->mockClient([
            new Response(200, [], '{}'),
        ], new ClientOptions(headers: ['X-Trace' => 'abc']));

        $client->zones()->get('zone_id');

        $this->assertSame('abc', $this->lastRequest()->getHeaderLine('X-Trace'));
        $this->assertSame('Bearer token', $this->lastRequest()->getHeaderLine('Authorization'));
    }

    #[TestWith(['User-Agent'])]
    #[TestWith(['user-agent'])]
    #[Test]
    public function shouldAllowOverridingUserAgentCaseInsensitively(string $header)
    {
        $client = $this->mockClient([
            new Response(200, [], '{}'),
        ], new ClientOptions(headers: [$header => 'my-app/1.0']));

        $client->zones()->get('zone_id');

        $this->assertSame(['my-app/1.0'], $this->lastRequest()->getHeader('User-Agent'));
    }

    #[TestWith(['Authorization'])]
    #[TestWith(['authorization'])]
    #[Test]
    public function shouldNotAllowOverridingAuthorizationHeader(string $header)
    {
        $client = $this->mockClient([
            new Response(200, [], '{}'),
        ], new ClientOptions(headers: [$header => 'Bearer leaked']));

        $client->zones()->get('zone_id');

        $this->assertSame(['Bearer token'], $this->lastRequest()->getHeader('Authorization'));
    }

    #[Test]
    public function shouldApplyMiddlewaresFromOptions()
    {
        $seen = null;

        $client = $this->mockClient([
            new Response(200, [], '{}'),
        ], new ClientOptions(middlewares: [
            function (callable $handler) use (&$seen) {
                return function ($request, array $options) use ($handler, &$seen) {
                    $seen = $request->getUri()->getPath();

                    return $handler($request, $options);
                };
            },
        ]));

        $client->zones()->get('zone_id');

        $this->assertSame('/client/v4/zones/zone_id', $seen);
    }

    #[Test]
    public function shouldIssueHeadRequest()
    {
        $client = $this->mockClient([
            new Response(200, [], ''),
        ]);

        $response = $client->getHttpClient()->head('/zones');

        $this->assertTrue($response->successful());
        $this->assertSame('HEAD', $this->lastRequest()->getMethod());
    }

    #[Test]
    public function shouldIssueHeadRequestWithQuery()
    {
        $client = $this->mockClient([
            new Response(200, [], ''),
        ]);

        $client->getHttpClient()->head('/zones', ['name' => 'example.com']);

        $this->assertStringContainsString('name=example.com', $this->lastRequest()->getUri()->getQuery());
    }

    #[TestWith([400, BadRequestException::class])]
    #[TestWith([401, AuthenticationException::class])]
    #[TestWith([403, PermissionDeniedException::class])]
    #[TestWith([404, NotFoundException::class])]
    #[TestWith([422, UnprocessableEntityException::class])]
    #[TestWith([429, RateLimitException::class])]
    #[TestWith([500, InternalServerException::class])]
    #[TestWith([503, InternalServerException::class])]
    #[TestWith([418, RequestException::class])]
    #[Test]
    public function shouldThrowMappedExceptionForStatus(int $status, string $expectedException)
    {
        $client = $this->mockClient([
            new Response($status, [], json_encode(['success' => false, 'errors' => [['message' => 'failed']]])),
        ]);

        $this->expectException($expectedException);

        $client->zones()->get('zone_id');
    }

    #[Test]
    public function shouldWrapConnectExceptionIntoConnectionException()
    {
        $request = new Request('GET', 'https://api.cloudflare.com/client/v4/zones/zone_id');
        $mock = new \GuzzleHttp\Handler\MockHandler([
            new ConnectException('Could not resolve host', $request),
        ]);

        $client = new \Cloudflare\Client('token', new \Cloudflare\ClientOptions(middlewares: [
            \GuzzleHttp\Middleware::history($this->requestHistory),
            fn (callable $handler) => fn ($req, array $options) => $mock($req, $options),
        ]));

        $this->expectException(ConnectionException::class);

        $client->zones()->get('zone_id');
    }
}
