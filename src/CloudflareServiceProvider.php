<?php

namespace Cloudflare;

use Illuminate\Contracts\Container\Container;
use Illuminate\Foundation\Application as LaravelApplication;
use Illuminate\Support\ServiceProvider;
use Laravel\Lumen\Application as LumenApplication;

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
        } elseif ($this->app instanceof LumenApplication) {
            $this->app->configure('cloudflare');
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
            return new Client(config('cloudflare.token'));
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
