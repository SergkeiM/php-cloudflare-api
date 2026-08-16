<?php

namespace Cloudflare\Tests\Endpoints\Tenants;

use Cloudflare\Exceptions\MissingArgumentException;
use Cloudflare\Tests\Concerns\InteractsWithMockClient;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class CustomNameserversTest extends TestCase
{
    use InteractsWithMockClient;

    #[Test]
    public function shouldGetDetails()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => [['ns_name' => 'ns1.example.com']]])),
        ]);

        $response = $client->tenants()->customNameservers()->get('tenant_id');

        $this->assertTrue($response->successful());
        $this->assertSame('GET', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/tenants/tenant_id/custom_ns', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldCreate()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => ['ns_name' => 'ns1.example.com']])),
        ]);

        $response = $client->tenants()->customNameservers()->create('tenant_id', [
            'ns_name' => 'ns1.example.com',
            'ns_set' => 1,
        ]);

        $this->assertTrue($response->successful());
        $this->assertSame('POST', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/tenants/tenant_id/custom_ns', $this->lastRequest()->getUri()->getPath());
        $this->assertSame([
            'ns_name' => 'ns1.example.com',
            'ns_set' => 1,
        ], json_decode((string) $this->lastRequest()->getBody(), true));
    }

    #[Test]
    public function shouldThrowMissingArgumentExceptionOnCreate()
    {
        $client = $this->mockClient([]);

        $this->expectException(MissingArgumentException::class);

        $client->tenants()->customNameservers()->create('tenant_id', ['ns_set' => 1]);
    }

    #[Test]
    public function shouldDelete()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => null])),
        ]);

        $response = $client->tenants()->customNameservers()->delete('tenant_id', 'ns1.example.com');

        $this->assertTrue($response->successful());
        $this->assertSame('DELETE', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/tenants/tenant_id/custom_ns/ns1.example.com', $this->lastRequest()->getUri()->getPath());
    }
}
