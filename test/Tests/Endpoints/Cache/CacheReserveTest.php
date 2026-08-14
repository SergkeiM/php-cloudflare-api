<?php

namespace Cloudflare\Tests\Endpoints\Cache;

use Cloudflare\Tests\Concerns\InteractsWithMockClient;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\TestWith;
use PHPUnit\Framework\TestCase;

class CacheReserveTest extends TestCase
{
    use InteractsWithMockClient;

    #[Test]
    public function shouldGetDetails()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => ['id' => 'cache_reserve', 'value' => 'on']])),
        ]);

        $response = $client->cache()->cacheReserve()->get('zone_id');

        $this->assertTrue($response->successful());
        $this->assertSame('GET', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/zones/zone_id/cache/cache_reserve', $this->lastRequest()->getUri()->getPath());
    }

    #[TestWith([true, 'on'])]
    #[TestWith([false, 'off'])]
    #[Test]
    public function shouldEdit(bool $enabled, string $expected)
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => ['id' => 'cache_reserve', 'value' => $expected]])),
        ]);

        $response = $client->cache()->cacheReserve()->edit('zone_id', $enabled);

        $this->assertTrue($response->successful());
        $this->assertSame('PATCH', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/zones/zone_id/cache/cache_reserve', $this->lastRequest()->getUri()->getPath());
        $this->assertSame(['value' => $expected], json_decode((string) $this->lastRequest()->getBody(), true));
    }

    #[Test]
    public function shouldClear()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => ['id' => 'cache_reserve_clear', 'state' => 'In-progress']])),
        ]);

        $response = $client->cache()->cacheReserve()->clear('zone_id');

        $this->assertTrue($response->successful());
        $this->assertSame('POST', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/zones/zone_id/cache/cache_reserve_clear', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldGetClearStatus()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => ['id' => 'cache_reserve_clear', 'state' => 'Completed']])),
        ]);

        $response = $client->cache()->cacheReserve()->status('zone_id');

        $this->assertTrue($response->successful());
        $this->assertSame('GET', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/zones/zone_id/cache/cache_reserve_clear', $this->lastRequest()->getUri()->getPath());
        $this->assertSame('Completed', $response->json('result.state'));
    }
}
