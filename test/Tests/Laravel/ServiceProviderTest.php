<?php

namespace Cloudflare\Tests\Laravel;

use Cloudflare\Client;
use GrahamCampbell\TestBenchCore\ServiceProviderTrait;

class ServiceProviderTest extends AbstractTestCase
{
    use ServiceProviderTrait;

    public function testCloudflareClientIsInjectable(): void
    {
        $this->assertIsInjectable(Client::class);
    }
}
