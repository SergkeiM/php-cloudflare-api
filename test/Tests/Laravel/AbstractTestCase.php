<?php

namespace Cloudflare\Tests\Laravel;

use Cloudflare\CloudflareServiceProvider;
use GrahamCampbell\TestBench\AbstractPackageTestCase;

abstract class AbstractTestCase extends AbstractPackageTestCase
{
    /**
     * Get the service provider class.
     *
     * @return string
     */
    protected static function getServiceProviderClass(): string
    {
        return CloudflareServiceProvider::class;
    }

    /**
     * Setup the application environment.
     *
     * @param \Illuminate\Contracts\Foundation\Application $app
     *
     * @return void
     */
    protected function getEnvironmentSetUp($app): void
    {
        parent::getEnvironmentSetUp($app);

        // The package ships without a credential, so give the container one to resolve.
        $app->config->set('cloudflare.auth.token', 'token');
    }
}
