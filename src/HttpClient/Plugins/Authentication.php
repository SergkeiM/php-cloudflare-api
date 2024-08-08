<?php

namespace SergkeiM\CloudFlare\HttpClient\Plugins;

use Http\Client\Common\Plugin;
use Http\Promise\Promise;
use Psr\Http\Message\RequestInterface;

final class Authentication implements Plugin
{
    /**
     * @var string
     */
    private $token;

    /**
     * @param string      $token    CloudFlare bearer token
     */
    public function __construct(string $token)
    {
        $this->token = $token;
    }

    /**
     * @return Promise
     */
    public function handleRequest(RequestInterface $request, callable $next, callable $first): Promise
    {

        $request = $request->withHeader('Authorization', "Bearer {$this->token}");

        return $next($request);
    }
}
