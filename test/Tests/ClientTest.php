<?php

namespace SergkeiM\CloudFlare\Tests;

use Psr\Http\Client\ClientInterface;
use SergkeiM\CloudFlare\Client;
use SergkeiM\CloudFlare\Endpoints;
use SergkeiM\CloudFlare\Exceptions\BadMethodCallException;
use SergkeiM\CloudFlare\Exceptions\InvalidArgumentException;

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
     */
    public function shouldPassHttpClientInterfaceToConstructor()
    {
        $httpClientMock = $this->getMockBuilder(ClientInterface::class)
            ->getMock();

        $client = Client::createWithHttpClient('token', $httpClientMock);

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
        ];
    }
}
