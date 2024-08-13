<?php

namespace SergkeiM\CloudFlare\Tests\Endpoints;

use Psr\Http\Client\ClientInterface;
use ReflectionMethod;
use SergkeiM\CloudFlare\Client;
use GuzzleHttp\Psr7\Response as Psr7Response;
use SergkeiM\CloudFlare\HttpClient\Response;

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
            ->setMethods(['sendGet', 'sendPost', 'sendPostRaw', 'sendPatch', 'sendDelete', 'sendPut', 'sendHead'])
            ->setConstructorArgs([$client])
            ->getMock();
    }

    /**
     * @return Response
     */
    protected function getResponseMock($body = null, $status = 200, $headers = [])
    {
        if (is_array($body)) {

            $body = json_encode($body);

            $headers['Content-Type'] = 'application/json';
        }

        $response = new Psr7Response($status, $headers, $body);

        return new Response($response);
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
