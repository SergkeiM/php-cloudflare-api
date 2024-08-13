<?php

namespace SergkeiM\CloudFlare;

use Http\Client\Common\HttpMethodsClientInterface;
use Http\Client\Common\Plugin;
use Http\Discovery\Psr17FactoryDiscovery;
use Psr\Http\Client\ClientInterface;
use SergkeiM\CloudFlare\Endpoints\AbstractEndpoint;
use SergkeiM\CloudFlare\Exceptions\BadMethodCallException;
use SergkeiM\CloudFlare\Exceptions\InvalidArgumentException;
use SergkeiM\CloudFlare\HttpClient\Builder;
use SergkeiM\CloudFlare\HttpClient\Plugins\Authentication;
use SergkeiM\CloudFlare\HttpClient\Plugins\ExceptionThrower;

/**
 * Simple PHP CloudFlare client.
 *
 * @method Endpoints\Accounts accounts()
 * @method Endpoints\Zones zones()
 *
 * @author Sergkei Melingk <sergio11of@gmail.com>
 *
 * Website: https://github.com/SergkeiM/php-cloudflare-api
 */
class Client
{
    /**
     * @var Builder
     */
    private $httpClientBuilder;

    public function __construct(
        private string $token,
        Builder $httpClientBuilder = null
    ) {

        $this->httpClientBuilder = $httpClientBuilder ?? new Builder();

        $baseUri = Psr17FactoryDiscovery::findUriFactory()
            ->createUri('https://api.cloudflare.com/client/v4/');

        $this->httpClientBuilder->addPlugin(new ExceptionThrower());
        $this->httpClientBuilder->addPlugin(new Authentication($token));
        $this->httpClientBuilder->addPlugin(new Plugin\BaseUriPlugin($baseUri));
        $this->httpClientBuilder->addPlugin(new Plugin\HeaderDefaultsPlugin([
            'Content-Type' => 'application/json',
            'User-Agent' => 'php-cloudflare-api (https://github.com/SergkeiM/php-cloudflare-api)',
        ]));
    }

    /**
     * Set CloudFlare Token
     *
     * @param string $token
     *
     * @return self
     */
    public function setToken(string $token): self
    {
        $this->token = $token;

        return $this;
    }

    /**
     * Create a CloudFlare\Client using a custom HTTP client.
     *
     * @param ClientInterface $httpClient
     *
     * @return self
     */
    public static function createWithHttpClient(string $token, ClientInterface $httpClient): self
    {
        $builder = new Builder($httpClient);

        return new self($token, $builder);
    }

    /**
     * @return HttpMethodsClientInterface
     */
    public function getHttpClient(): HttpMethodsClientInterface
    {
        return $this->getHttpClientBuilder()->getHttpClient();
    }

    /**
     * @return Builder
     */
    protected function getHttpClientBuilder(): Builder
    {
        return $this->httpClientBuilder;
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
