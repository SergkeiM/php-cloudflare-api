<?php

namespace Cloudflare;

use Cloudflare\Endpoints\AbstractEndpoint;
use Cloudflare\Exceptions\BadMethodCallException;
use Cloudflare\Exceptions\InvalidArgumentException;
use Cloudflare\HttpClient\HttpClient;

/**
 * Simple PHP Cloudflare client.
 *
 * @method \Cloudflare\Endpoints\Accounts accounts()
 * @method \Cloudflare\Endpoints\Zones zones()
 * @method \Cloudflare\Endpoints\IP ips()
 * @method \Cloudflare\Endpoints\Workers workers()
 * @method \Cloudflare\Endpoints\Tunnel tunnel()
 * @method \Cloudflare\Endpoints\D1 d1()
 * @method \Cloudflare\Endpoints\LoadBalancers loadBalancers()
 * @method \Cloudflare\Endpoints\Rulesets rulesets()
 * @method \Cloudflare\Endpoints\DNS dns()
 * @method \Cloudflare\Endpoints\DNSSEC dnssec()
 * @method \Cloudflare\Endpoints\PageRules pageRules()
 * @method \Cloudflare\Endpoints\Lockdown lockdown()
 * @method \Cloudflare\Endpoints\Ssl ssl()
 * @method \Cloudflare\Endpoints\OriginCACertificates originCACertificates()
 * @method \Cloudflare\Endpoints\Filters filters()
 * @method \Cloudflare\Endpoints\FirewallRules firewallRules()
 * @method \Cloudflare\Endpoints\AccessRules accessRules()
 * @method \Cloudflare\Endpoints\RateLimits rateLimits()
 * @method \Cloudflare\Endpoints\BotManagement botManagement()
 * @method \Cloudflare\Endpoints\CloudConnector cloudConnector()
 * @method \Cloudflare\Endpoints\R2 r2()
 * @method \Cloudflare\Endpoints\Iam iam()
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

        $api = match ($name) {
            'accounts' => new Endpoints\Accounts($this),
            'zones' => new Endpoints\Zones($this),
            'ips' => new Endpoints\IP($this),
            'workers' => new Endpoints\Workers($this),
            'tunnel' => new Endpoints\Tunnel($this),
            'd1' => new Endpoints\D1($this),
            'loadBalancers' => new Endpoints\LoadBalancers($this),
            'rulesets' => new Endpoints\Rulesets($this),
            'dns' => new Endpoints\DNS($this),
            'dnssec' => new Endpoints\DNSSEC($this),
            'pageRules' => new Endpoints\PageRules($this),
            'lockdown' => new Endpoints\Lockdown($this),
            'ssl' => new Endpoints\Ssl($this),
            'originCACertificates' => new Endpoints\OriginCACertificates($this),
            'filters' => new Endpoints\Filters($this),
            'firewallRules' => new Endpoints\FirewallRules($this),
            'accessRules' => new Endpoints\AccessRules($this),
            'rateLimits' => new Endpoints\RateLimits($this),
            'botManagement' => new Endpoints\BotManagement($this),
            'cloudConnector' => new Endpoints\CloudConnector($this),
            'r2' => new Endpoints\R2($this),
            'iam' => new Endpoints\Iam($this),
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
