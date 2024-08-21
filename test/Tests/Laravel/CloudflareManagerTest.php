<?php

namespace Cloudflare\Tests\Laravel;

use Cloudflare\Client;
use Cloudflare\CloudflareFactory;
use Cloudflare\CloudflareManager;
use GrahamCampbell\TestBench\AbstractTestCase as AbstractTestBenchTestCase;
use Illuminate\Contracts\Config\Repository;
use Mockery;

class CloudflareManagerTest extends AbstractTestBenchTestCase
{
    public function testCreateConnection(): void
    {
        $config = ['token' => 'your-token'];

        $manager = self::getManager($config);

        $manager->getConfig()->shouldReceive('get')->once()
            ->with('cloudflare.default')->andReturn('main');

        self::assertSame([], $manager->getConnections());

        $return = $manager->connection();

        self::assertInstanceOf(Client::class, $return);

        self::assertArrayHasKey('main', $manager->getConnections());
    }

    private static function getManager(array $config): CloudflareManager
    {
        $repo = Mockery::mock(Repository::class);
        $factory = Mockery::mock(CloudflareFactory::class);

        $manager = new CloudflareManager($repo, $factory);

        $manager->getConfig()->shouldReceive('get')->once()
            ->with('cloudflare.connections')->andReturn(['main' => $config]);

        $config['name'] = 'main';

        $manager->getFactory()->shouldReceive('make')->once()
            ->with($config)->andReturn(Mockery::mock(Client::class));

        return $manager;
    }
}
