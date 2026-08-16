<?php

namespace Cloudflare\Tests\Endpoints\Zones;

use Cloudflare\Tests\Concerns\InteractsWithMockClient;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class SubscriptionsTest extends TestCase
{
    use InteractsWithMockClient;

    #[Test]
    public function shouldGetDetails()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => ['id' => 'subscription_id']])),
        ]);

        $response = $client->zones()->subscriptions()->get('zone_id');

        $this->assertTrue($response->successful());
        $this->assertSame('GET', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/zones/zone_id/subscription', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldCreate()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => ['id' => 'subscription_id']])),
        ]);

        $response = $client->zones()->subscriptions()->create('zone_id', [
            'frequency' => 'monthly',
            'rate_plan' => ['id' => 'PARTNERS_PRO'],
        ]);

        $this->assertTrue($response->successful());
        $this->assertSame('POST', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/zones/zone_id/subscription', $this->lastRequest()->getUri()->getPath());
        $this->assertSame([
            'frequency' => 'monthly',
            'rate_plan' => ['id' => 'PARTNERS_PRO'],
        ], json_decode((string) $this->lastRequest()->getBody(), true));
    }

    #[Test]
    public function shouldUpdate()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => ['id' => 'subscription_id']])),
        ]);

        $response = $client->zones()->subscriptions()->update('zone_id', ['frequency' => 'yearly']);

        $this->assertTrue($response->successful());
        $this->assertSame('PUT', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/zones/zone_id/subscription', $this->lastRequest()->getUri()->getPath());
        $this->assertSame(['frequency' => 'yearly'], json_decode((string) $this->lastRequest()->getBody(), true));
    }

    #[Test]
    public function shouldDelete()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => ['subscription_id' => 'subscription_id']])),
        ]);

        $response = $client->zones()->subscriptions()->delete('zone_id');

        $this->assertTrue($response->successful());
        $this->assertSame('DELETE', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/zones/zone_id/subscription', $this->lastRequest()->getUri()->getPath());
    }
}
