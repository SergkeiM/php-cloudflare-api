<?php

namespace Cloudflare\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Facade for the Cloudflare client.
 *
 * @method static \Cloudflare\Endpoints\Accounts accounts()
 * @method static \Cloudflare\Endpoints\User user()
 * @method static \Cloudflare\Endpoints\Organizations organizations()
 * @method static \Cloudflare\Endpoints\Memberships memberships()
 * @method static \Cloudflare\Endpoints\Tenants tenants()
 * @method static \Cloudflare\Endpoints\Iam iam()
 * @method static \Cloudflare\Endpoints\Zones zones()
 * @method static \Cloudflare\Endpoints\DNS dns()
 * @method static \Cloudflare\Endpoints\PageRules pageRules()
 * @method static \Cloudflare\Endpoints\Rulesets rulesets()
 * @method static \Cloudflare\Endpoints\Firewall firewall()
 * @method static \Cloudflare\Endpoints\BotManagement botManagement()
 * @method static \Cloudflare\Endpoints\Ssl ssl()
 * @method static \Cloudflare\Endpoints\OriginCACertificates originCACertificates()
 * @method static \Cloudflare\Endpoints\Cache cache()
 * @method static \Cloudflare\Endpoints\LoadBalancers loadBalancers()
 * @method static \Cloudflare\Endpoints\CloudConnector cloudConnector()
 * @method static \Cloudflare\Endpoints\Zaraz zaraz()
 * @method static \Cloudflare\Endpoints\GoogleTagGateway googleTagGateway()
 * @method static \Cloudflare\Endpoints\Workers workers()
 * @method static \Cloudflare\Endpoints\KV kv()
 * @method static \Cloudflare\Endpoints\DurableObjects durableObjects()
 * @method static \Cloudflare\Endpoints\D1 d1()
 * @method static \Cloudflare\Endpoints\R2 r2()
 * @method static \Cloudflare\Endpoints\ZeroTrust zeroTrust()
 * @method static \Cloudflare\Endpoints\IP ips()
 *
 * @method static \Cloudflare\HttpClient\HttpClient getHttpClient()
 * @method static \Cloudflare\ClientOptions getOptions()
 * @method static \Cloudflare\HttpClient\Paginator paginate(callable $fetch, array $params = [])
 * @method static \Cloudflare\Endpoints\AbstractEndpoint api(string $name)
 *
 * @see \Cloudflare\Client
 */
class Cloudflare extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'cloudflare';
    }
}
