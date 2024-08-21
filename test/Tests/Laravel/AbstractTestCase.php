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
}
