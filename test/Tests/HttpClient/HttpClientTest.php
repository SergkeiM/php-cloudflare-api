<?php

namespace Cloudflare\Tests\HttpClient;

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

        $client = new \Cloudflare\Client('token', [
            \GuzzleHttp\Middleware::history($this->requestHistory),
            fn (callable $handler) => fn ($req, array $options) => $mock($req, $options),
        ]);

        $this->expectException(ConnectionException::class);

        $client->zones()->get('zone_id');
    }
}
