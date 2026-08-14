<?php

namespace Cloudflare\Tests\Laravel;

use Cloudflare\Client;
use Cloudflare\ClientOptions;
use GrahamCampbell\TestBenchCore\ServiceProviderTrait;

class ServiceProviderTest extends AbstractTestCase
{
    use ServiceProviderTrait;

    public function testCloudflareClientIsInjectable(): void
    {
        $this->assertIsInjectable(Client::class);
    }

    public function testCloudflareClientUsesDefaultOptions(): void
    {
        $options = $this->app->make('cloudflare')->getOptions();

        $this->assertSame(ClientOptions::DEFAULT_BASE_URL, $options->baseUrl);
        $this->assertSame(ClientOptions::DEFAULT_TIMEOUT, $options->timeout);
        $this->assertSame(ClientOptions::DEFAULT_CONNECT_TIMEOUT, $options->connectTimeout);
        $this->assertSame([], $options->headers);
        $this->assertSame(ClientOptions::DEFAULT_MAX_RETRIES, $options->maxRetries);
    }

    public function testCloudflareClientReadsOptionsFromConfig(): void
    {
        $this->app['config']->set('cloudflare.base_url', 'https://mock.test/api');
        $this->app['config']->set('cloudflare.timeout', 90);
        $this->app['config']->set('cloudflare.connect_timeout', 3);
        $this->app['config']->set('cloudflare.headers', ['X-Trace' => 'abc']);
        $this->app['config']->set('cloudflare.max_retries', 5);

        $options = $this->app->make('cloudflare')->getOptions();

        $this->assertSame('https://mock.test/api/', $options->baseUrl);
        $this->assertSame(90.0, $options->timeout);
        $this->assertSame(3.0, $options->connectTimeout);
        $this->assertSame(['X-Trace' => 'abc'], $options->headers);
        $this->assertSame(5, $options->maxRetries);
    }
}
