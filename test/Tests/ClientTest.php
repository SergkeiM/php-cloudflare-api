<?php

namespace Cloudflare\Tests;

use Cloudflare\Client;
use Cloudflare\Endpoints;
use Cloudflare\Exceptions\BadMethodCallException;
use Cloudflare\Exceptions\InvalidArgumentException;

class ClientTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @test
     *
     * @dataProvider getApiClassesProvider
     */
    public function shouldGetApiInstance($apiName, $class)
    {
        $client = new Client('token');

        $this->assertInstanceOf($class, $client->api($apiName));
    }

    /**
     * @test
     *
     * @dataProvider getApiClassesProvider
     */
    public function shouldGetMagicApiInstance($apiName, $class)
    {
        $client = new Client('token');

        $this->assertInstanceOf($class, $client->$apiName());
    }

    /**
     * @test
     */
    public function shouldNotGetApiInstance()
    {
        $this->expectException(InvalidArgumentException::class);

        $client = new Client('token');
        $client->api('do_not_exist');
    }

    /**
     * @test
     */
    public function shouldNotGetMagicApiInstance()
    {
        $this->expectException(BadMethodCallException::class);

        $client = new Client('token');
        $client->doNotExist();
    }

    public function getApiClassesProvider()
    {
        return [
            ['accounts', Endpoints\Accounts::class],
            ['ips', Endpoints\IP::class],
            ['workers', Endpoints\Workers::class],
            ['zones', Endpoints\Zones::class],
        ];
    }
}
