<?php

namespace CloudFlare;

use CloudFlare\Endpoints\AbstractEndpoint;
use CloudFlare\Exceptions\BadMethodCallException;
use CloudFlare\Exceptions\InvalidArgumentException;
use CloudFlare\HttpClient\HttpClient;

/**
 * Simple PHP CloudFlare client.
 *
 * @method Endpoints\Accounts accounts()
 * @method Endpoints\Zones zones()
 * @method Endpoints\IP ips()
 *
 * @author Sergkei Melingk <sergio11of@gmail.com>
 *
 * Website: https://github.com/SergkeiM/php-cloudflare-api
 */
class Client
{
    /**
     * HTTP Client wrapper for Guzzle.
     * @var HttpClient
     */
    private $httpClient;

    /**
     * @param string $token CloudFlare Token https://developers.cloudflare.com/fundamentals/api/get-started/create-token
     * @param array $middlewares Guzzle middlewares. https://docs.guzzlephp.org/en/stable/handlers-and-middleware.html#middleware
     * @return void
     */
    public function __construct(
        string $token,
        array $middlewares = []
    ) {

        $this->httpClient = new HttpClient($token, $middlewares);
    }

    /**
     * @return HttpClient HTTP Client wrapper for Guzzle.
     */
    public function getHttpClient(): HttpClient
    {
        return $this->httpClient;
    }

    /**
     * @param string $name
     *
     * @throws InvalidArgumentException
     *
     * @return AbstractEndpoint
     */
    public function api(string $name): AbstractEndpoint
    {
        switch ($name) {
            case 'accounts':
                $api = new Endpoints\Accounts($this);
                break;
            case 'zones':
                $api = new Endpoints\Zones($this);
                break;
            case 'ips':
                $api = new Endpoints\IP($this);
                break;
            case 'workers':
                $api = new Endpoints\IP($this);
                break;

            default:
                throw new InvalidArgumentException(sprintf('Undefined api instance called: "%s"', $name));
        }

        return $api;
    }

    /**
     * @param string $name
     * @param array  $args
     *
     * @return AbstractEndpoint
     */
    public function __call(string $name, array $args): AbstractEndpoint
    {
        try {
            return $this->api($name);
        } catch (InvalidArgumentException $e) {
            throw new BadMethodCallException(sprintf('Undefined method called: "%s"', $name));
        }
    }
}
