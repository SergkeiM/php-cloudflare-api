<?php

namespace SergkeiM\CloudFlare\Tests\Endpoints;

use Closure;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\ResponseInterface;
use ReflectionMethod;
use SergkeiM\CloudFlare\Client;
use SergkeiM\CloudFlare\HttpClient\Paginator;

abstract class TestCase extends \PHPUnit\Framework\TestCase
{
    /**
     * @return string
     */
    abstract protected function getApiClass();

    /**
     * @return \PHPUnit\Framework\MockObject\MockObject
     */
    protected function getApiMock()
    {
        $httpClient = $this->getMockBuilder(ClientInterface::class)
            ->setMethods(['sendRequest'])
            ->getMock();
        $httpClient
            ->expects($this->any())
            ->method('sendRequest');

        $client = Client::createWithHttpClient('token', $httpClient);

        return $this->getMockBuilder($this->getApiClass())
            ->setMethods(['get', 'post', 'postRaw', 'patch', 'delete', 'put', 'head'])
            ->setConstructorArgs([$client])
            ->getMock();
    }

    /**
     * @return \PHPUnit\Framework\MockObject\MockObject
     */
    protected function getResponseMock()
    {
        return $this->getMockBuilder(ResponseInterface::class)
            ->getMock();
    }

    /**
     * @return \PHPUnit\Framework\MockObject\MockObject
     */
    protected function getPaginatorMock(int $page, int $perPage, array $parameters, Closure $closure)
    {
        return $this->getMockBuilder(Paginator::class)
            ->setConstructorArgs([$page, $perPage, $parameters, $closure])
            ->getMock();
    }

    /**
     * @param object $object
     * @param string $methodName
     *
     * @return ReflectionMethod
     */
    protected function getMethod($object, $methodName)
    {
        $method = new ReflectionMethod($object, $methodName);
        $method->setAccessible(true);

        return $method;
    }
}
