<?php

namespace Cloudflare\Tests\Laravel;

use Cloudflare\Client;
use Cloudflare\CloudflareFactory;
use GrahamCampbell\TestBench\AbstractTestCase as AbstractTestBenchTestCase;

class CloudflareFactoryTest extends AbstractTestBenchTestCase
{
    public function testMakeStandard(): void
    {
        $factory = self::getFactory();

        $client = $factory->make(['token' => 'your-token']);

        self::assertInstanceOf(Client::class, $client);
    }

    /**
     * @return \Cloudflare\CloudflareFactory
     */
    private static function getFactory(): CloudflareFactory
    {
        return new CloudflareFactory();
    }
}
