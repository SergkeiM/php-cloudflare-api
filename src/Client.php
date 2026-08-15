<?php

namespace Cloudflare;

use Cloudflare\Endpoints\AbstractEndpoint;
use Cloudflare\Exceptions\BadMethodCallException;
use Cloudflare\Exceptions\InvalidArgumentException;
use Cloudflare\HttpClient\HttpClient;
use Cloudflare\HttpClient\Paginator;

/**
 * Simple PHP Cloudflare client.
 *
 * @method \Cloudflare\Endpoints\Accounts accounts()
 * @method \Cloudflare\Endpoints\User user()
 * @method \Cloudflare\Endpoints\Organizations organizations()
 * @method \Cloudflare\Endpoints\Memberships memberships()
 * @method \Cloudflare\Endpoints\Tenants tenants()
 * @method \Cloudflare\Endpoints\Iam iam()
 * @method \Cloudflare\Endpoints\Zones zones()
 * @method \Cloudflare\Endpoints\DNS dns()
 * @method \Cloudflare\Endpoints\PageRules pageRules()
 * @method \Cloudflare\Endpoints\Rulesets rulesets()
 * @method \Cloudflare\Endpoints\Firewall firewall()
 * @method \Cloudflare\Endpoints\BotManagement botManagement()
 * @method \Cloudflare\Endpoints\Ssl ssl()
 * @method \Cloudflare\Endpoints\OriginCACertificates originCACertificates()
 * @method \Cloudflare\Endpoints\Cache cache()
 * @method \Cloudflare\Endpoints\LoadBalancers loadBalancers()
 * @method \Cloudflare\Endpoints\CloudConnector cloudConnector()
 * @method \Cloudflare\Endpoints\Zaraz zaraz()
 * @method \Cloudflare\Endpoints\GoogleTagGateway googleTagGateway()
 * @method \Cloudflare\Endpoints\Workers workers()
 * @method \Cloudflare\Endpoints\KV kv()
 * @method \Cloudflare\Endpoints\DurableObjects durableObjects()
 * @method \Cloudflare\Endpoints\D1 d1()
 * @method \Cloudflare\Endpoints\R2 r2()
 * @method \Cloudflare\Endpoints\ZeroTrust zeroTrust()
 * @method \Cloudflare\Endpoints\IP ips()
 *
 * @author Sergkei Melingk <sergio11of@gmail.com>
 *
 * Website: https://github.com/SergkeiM/php-cloudflare-api
 */
class Client
{
    /**
     * HTTP Client wrapper for Guzzle.
     */
    private readonly HttpClient $httpClient;

    /**
     * @param string $token Cloudflare Token https://developers.cloudflare.com/fundamentals/api/get-started/create-token
     * @param ClientOptions|null $options Transport configuration (base URL, timeouts, headers, retries, Guzzle middlewares). Defaults to `new ClientOptions()`.
     * @return void
     */
    public function __construct(
        string $token,
        ?ClientOptions $options = null
    ) {

        $this->httpClient = new HttpClient($token, $options);
    }

    /**
     * @return HttpClient HTTP Client wrapper for Guzzle.
     */
    public function getHttpClient(): HttpClient
    {
        return $this->httpClient;
    }

    /**
     * @return ClientOptions Transport configuration this client was built with.
     */
    public function getOptions(): ClientOptions
    {
        return $this->httpClient->getOptions();
    }

    /**
     * Iterate over every entry of a list endpoint, page by page.
     *
     * The callable is handed the query parameters for a page and returns that
     * page, so any endpoint whose last argument is `array $params` fits:
     *
     * ```php
     * $zones = $client->paginate(
     *     fn (array $params) => $client->zones()->list('ACCOUNT_ID', $params),
     *     ['per_page' => 100]
     * );
     *
     * foreach ($zones as $zone) {
     *     echo $zone['name'];
     * }
     * ```
     *
     * Pages are requested as they are consumed, so nothing is fetched until
     * iteration starts and nothing further is fetched once it stops.
     *
     * @param callable(array): \Cloudflare\Contracts\ResponseInterface $fetch Fetches one page from the query parameters it is given.
     * @param array $params Query Parameters sent with the first page, and carried over to every page after it.
     *
     * @return Paginator
     */
    public function paginate(callable $fetch, array $params = []): Paginator
    {
        return new Paginator($fetch, $params);
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

        $api = match ($name) {
            'accounts' => new Endpoints\Accounts($this),
            'user' => new Endpoints\User($this),
            'organizations' => new Endpoints\Organizations($this),
            'memberships' => new Endpoints\Memberships($this),
            'tenants' => new Endpoints\Tenants($this),
            'iam' => new Endpoints\Iam($this),
            'zones' => new Endpoints\Zones($this),
            'dns' => new Endpoints\DNS($this),
            'pageRules' => new Endpoints\PageRules($this),
            'rulesets' => new Endpoints\Rulesets($this),
            'firewall' => new Endpoints\Firewall($this),
            'botManagement' => new Endpoints\BotManagement($this),
            'ssl' => new Endpoints\Ssl($this),
            'originCACertificates' => new Endpoints\OriginCACertificates($this),
            'cache' => new Endpoints\Cache($this),
            'loadBalancers' => new Endpoints\LoadBalancers($this),
            'cloudConnector' => new Endpoints\CloudConnector($this),
            'zaraz' => new Endpoints\Zaraz($this),
            'googleTagGateway' => new Endpoints\GoogleTagGateway($this),
            'workers' => new Endpoints\Workers($this),
            'kv' => new Endpoints\KV($this),
            'durableObjects' => new Endpoints\DurableObjects($this),
            'd1' => new Endpoints\D1($this),
            'r2' => new Endpoints\R2($this),
            'zeroTrust' => new Endpoints\ZeroTrust($this),
            'ips' => new Endpoints\IP($this),
            default => throw new InvalidArgumentException(sprintf('Undefined api instance called: "%s"', $name))
        };

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
