<?php

namespace Cloudflare\Tests\Laravel\Facades;

use Cloudflare\Facades\Cloudflare;
use Cloudflare\Client;
use GrahamCampbell\TestBenchCore\FacadeTrait;
use Cloudflare\Tests\Laravel\AbstractTestCase;

class CloudflareTest extends AbstractTestCase
{
    use FacadeTrait;

    /**
     * Get the facade accessor.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'cloudflare';
    }

    /**
     * Get the facade class.
     *
     * @return string
     */
    protected static function getFacadeClass(): string
    {
        return Cloudflare::class;
    }

    /**
     * Get the facade root.
     *
     * @return string
     */
    protected static function getFacadeRoot(): string
    {
        return Client::class;
    }
}
