<?php

namespace CloudFlare\Tests;

use Psr\Http\Client\ClientInterface;
use CloudFlare\Client;
use CloudFlare\Endpoints;
use CloudFlare\Exceptions\BadMethodCallException;
use CloudFlare\Exceptions\InvalidArgumentException;

class ClientTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @test
     */
    public function shouldNotHaveToPassHttpClientToConstructor()
    {
        $client = new Client('token');

        $this->assertInstanceOf(ClientInterface::class, $client->getHttpClient());
    }

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
            ['zones', Endpoints\Zones::class],
            ['workers', Endpoints\Workers::class],
            ['ips', Endpoints\IP::class],
        ];
    }
}
