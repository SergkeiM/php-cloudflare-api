<?php

namespace Cloudflare\Tests\Endpoints\Zones;

use Cloudflare\Tests\Concerns\InteractsWithMockClient;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class DNSSECTest extends TestCase
{
    use InteractsWithMockClient;

    #[Test]
    public function shouldGetDetails()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => ['status' => 'active']])),
        ]);

        $response = $client->zones()->dnssec()->details('zone_id');

        $this->assertTrue($response->successful());
        $this->assertSame('active', $response->json('result.status'));
        $this->assertSame('GET', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/zones/zone_id/dnssec', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldUpdate()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => ['status' => 'active']])),
        ]);

        $response = $client->zones()->dnssec()->update('zone_id', 'active', true, true);

        $this->assertTrue($response->successful());
        $this->assertSame('PATCH', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/zones/zone_id/dnssec', $this->lastRequest()->getUri()->getPath());
        $this->assertSame([
            'dnssec_multi_signer' => true,
            'dnssec_presigned' => true,
            'status' => 'active',
        ], json_decode((string) $this->lastRequest()->getBody(), true));
    }

    #[Test]
    public function shouldDelete()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => null])),
        ]);

        $response = $client->zones()->dnssec()->delete('zone_id');

        $this->assertTrue($response->successful());
        $this->assertSame('DELETE', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/zones/zone_id/dnssec', $this->lastRequest()->getUri()->getPath());
    }
}
