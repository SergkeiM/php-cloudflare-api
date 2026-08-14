<?php

namespace Cloudflare\Tests\Endpoints\Cache;

use Cloudflare\Tests\Concerns\InteractsWithMockClient;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\TestWith;
use PHPUnit\Framework\TestCase;

class RegionalTieredCacheTest extends TestCase
{
    use InteractsWithMockClient;

    #[Test]
    public function shouldGetDetails()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => ['id' => 'tc_regional', 'value' => 'off']])),
        ]);

        $response = $client->cache()->regionalTieredCache()->get('zone_id');

        $this->assertTrue($response->successful());
        $this->assertSame('GET', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/zones/zone_id/cache/regional_tiered_cache', $this->lastRequest()->getUri()->getPath());
    }

    #[TestWith([true, 'on'])]
    #[TestWith([false, 'off'])]
    #[Test]
    public function shouldEdit(bool $enabled, string $expected)
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => ['id' => 'tc_regional', 'value' => $expected]])),
        ]);

        $response = $client->cache()->regionalTieredCache()->edit('zone_id', $enabled);

        $this->assertTrue($response->successful());
        $this->assertSame('PATCH', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/zones/zone_id/cache/regional_tiered_cache', $this->lastRequest()->getUri()->getPath());
        $this->assertSame(['value' => $expected], json_decode((string) $this->lastRequest()->getBody(), true));
    }
}
