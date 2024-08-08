<?php

namespace SergkeiM\CloudFlare\HttpClient\Plugins;

use Http\Client\Common\Plugin;
use Http\Promise\Promise;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use SergkeiM\CloudFlare\Exceptions\RequestException;

final class ExceptionThrower implements Plugin
{
    /**
     * @return Promise
     */
    public function handleRequest(RequestInterface $request, callable $next, callable $first): Promise
    {
        return $next($request)->then(function (ResponseInterface $response) {

            $failed = $response->getStatusCode() >= 500 || ($response->getStatusCode() >= 400 && $response->getStatusCode() < 500);
            
            if($failed){
                throw new RequestException($response);
            }

            return $response;
        });
    }
}