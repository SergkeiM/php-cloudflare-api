<?php

namespace SergkeiM\CloudFlare;

use Http\Client\Common\HttpMethodsClientInterface;
use Http\Client\Common\Plugin;
use Http\Discovery\Psr17FactoryDiscovery;
use Psr\Http\Client\ClientInterface;
use SergkeiM\CloudFlare\Endpoints\AbstractApi;
use SergkeiM\CloudFlare\Exceptions\BadMethodCallException;
use SergkeiM\CloudFlare\Exceptions\InvalidArgumentException;
use SergkeiM\CloudFlare\HttpClient\Builder;
use SergkeiM\CloudFlare\HttpClient\Plugins\Authentication;
use SergkeiM\CloudFlare\HttpClient\Plugins\ExceptionThrower;

/**
 * Simple PHP CloudFlare client.
 *
 * @method Endpoints\Accounts accounts()
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
        string $token,
        Builder $httpClientBuilder = null
    ) {
        $this->httpClientBuilder = $builder = $httpClientBuilder ?? new Builder();

        $baseUri = Psr17FactoryDiscovery::findUriFactory()
            ->createUri('https://api.cloudflare.com/client/v4/');

        $builder->addPlugin(new Authentication($token));
        $builder->addPlugin(new Plugin\BaseUriPlugin($baseUri));
        $builder->addPlugin(new Plugin\HeaderDefaultsPlugin([
            'User-Agent' => 'php-cloudflare-api (https://github.com/SergkeiM/php-cloudflare-api)',
        ]));
        $builder->addPlugin(new ExceptionThrower());
    }

    /**
     * Create a CloudFlare\Client using a custom HTTP client.
     *
     * @param ClientInterface $httpClient
     *
     * @return Client
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
     * @return AbstractApi
     */
    public function api($name): AbstractApi
    {
        switch ($name) {
            case 'accounts':
                $api = new Endpoints\Accounts($this);
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
     * @return AbstractApi
     */
    public function __call(string $name, array $args): AbstractApi
    {
        try {
            return $this->api($name);
        } catch (InvalidArgumentException $e) {
            throw new BadMethodCallException(sprintf('Undefined method called: "%s"', $name));
        }
    }
}
