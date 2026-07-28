<?php

namespace Cloudflare\Tests\Endpoints;

use Cloudflare\Tests\Concerns\InteractsWithMockClient;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\Test;

class RateLimitsTest extends TestCase
{
    use InteractsWithMockClient;

    #[Test]
    public function shouldList()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => [['id' => 'rate_limit_id']]])),
        ]);

        $response = $client->rateLimits()->list('zone_id');

        $this->assertTrue($response->successful());
        $this->assertSame('GET', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/zones/zone_id/rate_limits', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldGet()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => ['id' => 'rate_limit_id']])),
        ]);

        $response = $client->rateLimits()->get('zone_id', 'rate_limit_id');

        $this->assertTrue($response->successful());
        $this->assertSame('GET', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/zones/zone_id/rate_limits/rate_limit_id', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldCreate()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => ['id' => 'rate_limit_id']])),
        ]);

        $response = $client->rateLimits()->create('zone_id', [
            'threshold' => 1000,
            'period' => 60,
            'match' => ['request' => ['url' => '*example.com/*']],
            'action' => ['mode' => 'simulate', 'timeout' => 60],
        ]);

        $this->assertTrue($response->successful());
        $this->assertSame('POST', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/zones/zone_id/rate_limits', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldUpdate()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => ['id' => 'rate_limit_id']])),
        ]);

        $response = $client->rateLimits()->update('zone_id', 'rate_limit_id', [
            'threshold' => 2000,
            'period' => 60,
            'match' => ['request' => ['url' => '*example.com/*']],
            'action' => ['mode' => 'simulate', 'timeout' => 60],
        ]);

        $this->assertTrue($response->successful());
        $this->assertSame('PUT', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/zones/zone_id/rate_limits/rate_limit_id', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldDelete()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => ['id' => 'rate_limit_id']])),
        ]);

        $response = $client->rateLimits()->delete('zone_id', 'rate_limit_id');

        $this->assertTrue($response->successful());
        $this->assertSame('DELETE', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/zones/zone_id/rate_limits/rate_limit_id', $this->lastRequest()->getUri()->getPath());
    }
}
