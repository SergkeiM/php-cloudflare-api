<?php

namespace Cloudflare\Tests\Endpoints\Zones;

use Cloudflare\Tests\Concerns\InteractsWithMockClient;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class HoldsTest extends TestCase
{
    use InteractsWithMockClient;

    #[Test]
    public function shouldGetDetails()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => ['hold' => true]])),
        ]);

        $response = $client->zones()->holds()->get('zone_id');

        $this->assertTrue($response->successful());
        $this->assertSame('GET', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/zones/zone_id/hold', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldCreate()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => ['hold' => true]])),
        ]);

        $response = $client->zones()->holds()->create('zone_id');

        $this->assertTrue($response->successful());
        $this->assertSame('POST', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/zones/zone_id/hold', $this->lastRequest()->getUri()->getPath());
        $this->assertSame(['include_subdomains' => true], json_decode((string) $this->lastRequest()->getBody(), true));
    }

    #[Test]
    public function shouldDeleteWithoutHoldAfter()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => ['hold' => false]])),
        ]);

        $response = $client->zones()->holds()->delete('zone_id');

        $this->assertTrue($response->successful());
        $this->assertSame('DELETE', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/zones/zone_id/hold', $this->lastRequest()->getUri()->getPath());
        $this->assertSame('', $this->lastRequest()->getUri()->getQuery());
    }

    #[Test]
    public function shouldDeleteWithHoldAfter()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => ['hold' => true]])),
        ]);

        $response = $client->zones()->holds()->delete('zone_id', '2030-01-01T00:00:00Z');

        $this->assertTrue($response->successful());
        $this->assertSame('DELETE', $this->lastRequest()->getMethod());
        $this->assertStringContainsString('hold_after=', $this->lastRequest()->getUri()->getQuery());
    }
}
