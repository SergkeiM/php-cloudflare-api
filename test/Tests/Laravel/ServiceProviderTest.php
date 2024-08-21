<?php

namespace Cloudflare\Tests\Laravel;

use Cloudflare\Client;
use Cloudflare\CloudflareFactory;
use Cloudflare\CloudflareManager;
use GrahamCampbell\TestBenchCore\ServiceProviderTrait;

class ServiceProviderTest extends AbstractTestCase
{
    use ServiceProviderTrait;

    public function testCloudflareFactoryIsInjectable(): void
    {
        $this->assertIsInjectable(CloudflareFactory::class);
    }

    public function testCloudflareManagerIsInjectable(): void
    {
        $this->assertIsInjectable(CloudflareManager::class);
    }

    public function testBindings(): void
    {
        $this->assertIsInjectable(Client::class);

        $original = $this->app['cloudflare.connection'];
        $this->app['cloudflare']->reconnect();
        $new = $this->app['cloudflare.connection'];

        self::assertNotSame($original, $new);
        self::assertEquals($original, $new);
    }
}
