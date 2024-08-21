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
        $this->registerCloudflareFactory();
        $this->registerManager();
        $this->registerBindings();
    }

    /**
     * Register the github factory class.
     *
     * @return void
     */
    private function registerCloudflareFactory(): void
    {
        $this->app->singleton('cloudflare.factory', function (Container $app): CloudflareFactory {
            return new CloudflareFactory();
        });

        $this->app->alias('cloudflare.factory', CloudflareFactory::class);
    }

    /**
     * Register the manager class.
     *
     * @return void
     */
    private function registerManager(): void
    {
        $this->app->singleton('cloudflare', function (Container $app): CloudflareManager {
            $config = $app['config'];
            $factory = $app['cloudflare.factory'];

            return new CloudflareManager($config, $factory);
        });

        $this->app->alias('cloudflare', CloudflareManager::class);
    }

    /**
     * Register the bindings.
     *
     * @return void
     */
    private function registerBindings(): void
    {
        $this->app->bind('cloudflare.connection', function (Container $app): Client {
            $manager = $app['cloudflare'];

            return $manager->connection();
        });

        $this->app->alias('cloudflare.connection', Client::class);
    }

    /**
     * Get the services provided by the provider.
     *
     * @return string[]
     */
    public function provides(): array
    {
        return [
            'cloudflare.factory',
            'cloudflare',
            'cloudflare.connection',
        ];
    }
}
