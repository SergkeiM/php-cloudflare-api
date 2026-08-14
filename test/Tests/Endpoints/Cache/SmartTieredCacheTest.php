<?php

namespace Cloudflare\Tests\Endpoints\Cache;

use Cloudflare\Tests\Concerns\InteractsWithMockClient;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\TestWith;
use PHPUnit\Framework\TestCase;

class SmartTieredCacheTest extends TestCase
{
    use InteractsWithMockClient;

    private const PATH = '/client/v4/zones/zone_id/cache/tiered_cache_smart_topology_enable';

    #[Test]
    public function shouldGetDetails()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => ['id' => 'tiered_cache_smart_topology_enable', 'value' => 'on']])),
        ]);

        $response = $client->cache()->smartTieredCache()->get('zone_id');

        $this->assertTrue($response->successful());
        $this->assertSame('GET', $this->lastRequest()->getMethod());
        $this->assertSame(self::PATH, $this->lastRequest()->getUri()->getPath());
    }

    #[TestWith([true, 'on'])]
    #[TestWith([false, 'off'])]
    #[Test]
    public function shouldCreate(bool $enabled, string $expected)
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => ['id' => 'tiered_cache_smart_topology_enable', 'value' => $expected]])),
        ]);

        $response = $client->cache()->smartTieredCache()->create('zone_id', $enabled);

        $this->assertTrue($response->successful());
        $this->assertSame('POST', $this->lastRequest()->getMethod());
        $this->assertSame(self::PATH, $this->lastRequest()->getUri()->getPath());
        $this->assertSame(['value' => $expected], json_decode((string) $this->lastRequest()->getBody(), true));
    }

    #[TestWith([true, 'on'])]
    #[TestWith([false, 'off'])]
    #[Test]
    public function shouldEdit(bool $enabled, string $expected)
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => ['id' => 'tiered_cache_smart_topology_enable', 'value' => $expected]])),
        ]);

        $response = $client->cache()->smartTieredCache()->edit('zone_id', $enabled);

        $this->assertTrue($response->successful());
        $this->assertSame('PATCH', $this->lastRequest()->getMethod());
        $this->assertSame(self::PATH, $this->lastRequest()->getUri()->getPath());
        $this->assertSame(['value' => $expected], json_decode((string) $this->lastRequest()->getBody(), true));
    }

    #[Test]
    public function shouldDelete()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => ['id' => 'tiered_cache_smart_topology_enable']])),
        ]);

        $response = $client->cache()->smartTieredCache()->delete('zone_id');

        $this->assertTrue($response->successful());
        $this->assertSame('DELETE', $this->lastRequest()->getMethod());
        $this->assertSame(self::PATH, $this->lastRequest()->getUri()->getPath());
    }
}
