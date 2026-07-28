<?php

namespace Cloudflare\Tests\Endpoints\Workers;

use Cloudflare\Tests\Concerns\InteractsWithMockClient;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class DomainsTest extends TestCase
{
    use InteractsWithMockClient;

    #[Test]
    public function shouldGet()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => [['id' => 'domain_id']]])),
        ]);

        $response = $client->workers()->domains()->list('account_id');

        $this->assertTrue($response->successful());
        $this->assertSame('GET', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/accounts/account_id/workers/domains', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldAttach()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => ['id' => 'domain_id']])),
        ]);

        $response = $client->workers()->domains()->attach('account_id', [
            'environment' => 'production',
            'hostname' => 'example.com',
            'service' => 'my-worker',
            'zone_id' => 'zone_id',
        ]);

        $this->assertTrue($response->successful());
        $this->assertSame('PUT', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/accounts/account_id/workers/domains', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldDetach()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => null])),
        ]);

        $response = $client->workers()->domains()->detach('account_id', 'domain_id');

        $this->assertTrue($response->successful());
        $this->assertSame('DELETE', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/accounts/account_id/workers/domains/domain_id', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldGetDomain()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => ['id' => 'domain_id']])),
        ]);

        $response = $client->workers()->domains()->get('account_id', 'domain_id');

        $this->assertTrue($response->successful());
        $this->assertSame('GET', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/accounts/account_id/workers/domains/domain_id', $this->lastRequest()->getUri()->getPath());
    }
}
