<?php

namespace Cloudflare;

use Cloudflare\ClientOptions;
use Illuminate\Contracts\Container\Container;
use Illuminate\Foundation\Application as LaravelApplication;
use Illuminate\Support\ServiceProvider;

class CloudflareServiceProvider extends ServiceProvider
{
    /**
     * Boot the service provider.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->setupConfig();
    }

    /**
     * Setup the config.
     *
     * @return void
     */
    private function setupConfig(): void
    {
        $source = realpath($raw = __DIR__.'/../config/cloudflare.php') ?: $raw;

        if ($this->app instanceof LaravelApplication && $this->app->runningInConsole()) {
            $this->publishes([$source => $this->app->configPath('cloudflare.php')]);
        }

        $this->mergeConfigFrom($source, 'cloudflare');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register(): void
    {
        $this->registerCloudflare();
    }

    /**
     * Register the Cloudflare Client class.
     *
     * @return void
     */
    private function registerCloudflare(): void
    {
        $this->app->singleton('cloudflare', function (Container $app): Client {
            $config = $app['config'];

            return new Client((string) $config->get('cloudflare.token'), new ClientOptions(
                baseUrl: $config->get('cloudflare.base_url'),
                timeout: (float) $config->get('cloudflare.timeout', ClientOptions::DEFAULT_TIMEOUT),
                connectTimeout: (float) $config->get('cloudflare.connect_timeout', ClientOptions::DEFAULT_CONNECT_TIMEOUT),
                headers: (array) $config->get('cloudflare.headers', []),
                maxRetries: (int) $config->get('cloudflare.max_retries', ClientOptions::DEFAULT_MAX_RETRIES),
            ));
        });

        $this->app->alias('cloudflare', Client::class);
    }

    /**
     * Get the services provided by the provider.
     *
     * @return string[]
     */
    public function provides(): array
    {
        return [
            'cloudflare',
        ];
    }
}
