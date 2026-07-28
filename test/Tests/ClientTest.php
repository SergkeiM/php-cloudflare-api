<?php

namespace Cloudflare\Tests;

use Cloudflare\Client;
use Cloudflare\Endpoints;
use Cloudflare\Exceptions\BadMethodCallException;
use Cloudflare\Exceptions\InvalidArgumentException;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;

class ClientTest extends \PHPUnit\Framework\TestCase
{
    #[Test]
    #[DataProvider('getApiClassesProvider')]
    public function shouldGetApiInstance($apiName, $class)
    {
        $client = new Client('token');

        $this->assertInstanceOf($class, $client->api($apiName));
    }

    #[Test]
    #[DataProvider('getApiClassesProvider')]
    public function shouldGetMagicApiInstance($apiName, $class)
    {
        $client = new Client('token');

        $this->assertInstanceOf($class, $client->$apiName());
    }

    #[Test]
    public function shouldNotGetApiInstance()
    {
        $this->expectException(InvalidArgumentException::class);

        $client = new Client('token');
        $client->api('do_not_exist');
    }

    #[Test]
    public function shouldNotGetMagicApiInstance()
    {
        $this->expectException(BadMethodCallException::class);

        $client = new Client('token');
        $client->doNotExist();
    }

    public static function getApiClassesProvider()
    {
        return [
            ['accounts', Endpoints\Accounts::class],
            ['ips', Endpoints\IP::class],
            ['workers', Endpoints\Workers::class],
            ['zones', Endpoints\Zones::class],
        ];
    }
}
