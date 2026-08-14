<?php

namespace Cloudflare\Tests\Endpoints;

use Cloudflare\Endpoints\Cache\CacheReserve;
use Cloudflare\Endpoints\Cache\RegionalTieredCache;
use Cloudflare\Endpoints\Cache\SmartTieredCache;
use Cloudflare\Endpoints\Cache\Variants;
use Cloudflare\Tests\Concerns\InteractsWithMockClient;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\TestWith;
use PHPUnit\Framework\TestCase;

class CacheTest extends TestCase
{
    use InteractsWithMockClient;

    #[TestWith(['cacheReserve', CacheReserve::class])]
    #[TestWith(['regionalTieredCache', RegionalTieredCache::class])]
    #[TestWith(['smartTieredCache', SmartTieredCache::class])]
    #[TestWith(['variants', Variants::class])]
    #[Test]
    public function shouldGetSubEndpoint(string $accessor, string $class)
    {
        $client = $this->mockClient([]);

        $this->assertInstanceOf($class, $client->cache()->{$accessor}());
    }
}
