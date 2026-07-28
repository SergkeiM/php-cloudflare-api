<?php

namespace Cloudflare\Tests\Endpoints\Zones;

use Cloudflare\Tests\Concerns\InteractsWithMockClient;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class LockdownTest extends TestCase
{
    use InteractsWithMockClient;

    #[Test]
    public function shouldList()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => [['id' => 'lockdown_id']]])),
        ]);

        $response = $client->zones()->lockdowns()->list('zone_id');

        $this->assertTrue($response->successful());
        $this->assertSame('GET', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/zones/zone_id/firewall/lockdowns', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldCreateWithSingleIp()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => ['id' => 'lockdown_id']])),
        ]);

        $response = $client->zones()->lockdowns()->create('zone_id', '127.0.0.1', ['example.com/*']);

        $this->assertTrue($response->successful());
        $this->assertSame('POST', $this->lastRequest()->getMethod());
        $body = json_decode((string) $this->lastRequest()->getBody(), true);
        $this->assertSame('ip', $body['configurations']['target']);
    }

    #[Test]
    public function shouldCreateWithIpRange()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => ['id' => 'lockdown_id']])),
        ]);

        $response = $client->zones()->lockdowns()->create('zone_id', '127.0.0.1/16', ['example.com/*']);

        $this->assertTrue($response->successful());
        $body = json_decode((string) $this->lastRequest()->getBody(), true);
        $this->assertSame('ip_range', $body['configurations']['target']);
    }

    #[Test]
    public function shouldGetDetails()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => ['id' => 'lockdown_id']])),
        ]);

        $response = $client->zones()->lockdowns()->details('zone_id', 'lockdown_id');

        $this->assertTrue($response->successful());
        $this->assertSame('GET', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/zones/zone_id/firewall/lockdowns/lockdown_id', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldUpdate()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => ['id' => 'lockdown_id']])),
        ]);

        $response = $client->zones()->lockdowns()->update('zone_id', 'lockdown_id', '127.0.0.1', ['example.com/*']);

        $this->assertTrue($response->successful());
        $this->assertSame('PUT', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/zones/zone_id/firewall/lockdowns/lockdown_id', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldDelete()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => ['id' => 'lockdown_id']])),
        ]);

        $response = $client->zones()->lockdowns()->delete('zone_id', 'lockdown_id');

        $this->assertTrue($response->successful());
        $this->assertSame('DELETE', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/zones/zone_id/firewall/lockdowns/lockdown_id', $this->lastRequest()->getUri()->getPath());
    }
}
