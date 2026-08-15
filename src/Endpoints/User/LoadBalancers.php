<?php

namespace Cloudflare\Endpoints\User;

use Cloudflare\Endpoints\AbstractEndpoint;
use Cloudflare\Contracts\ResponseInterface;
use Cloudflare\Endpoints\User\LoadBalancers\Monitors;
use Cloudflare\Endpoints\User\LoadBalancers\Pools;

/**
 * Load balancing owned by the authenticated user rather than by an account.
 *
 * The account-scoped counterpart is `$client->loadBalancers()`, which takes an
 * account identifier throughout.
 *
 * @link https://developers.cloudflare.com/load-balancing/
 */
class LoadBalancers extends AbstractEndpoint
{
    /**
     * List all region mappings in the user context.
     *
     * @param array $params Query Parameters: `subdivision_code` and `country_code`.
     *
     * @return ResponseInterface List regions response
     */
    public function regions(array $params = []): ResponseInterface
    {
        return $this->getHttpClient()->get('/user/load_balancers/regions', $params);
    }

    /**
     * Get the result of a previous preview operation.
     *
     * Previews are started from `monitors()->preview()` or `pools()->preview()`,
     * which hand back the identifier to read here.
     *
     * @param string $previewId Preview Identifier, as returned when the preview was started.
     *
     * @return ResponseInterface Preview result response
     */
    public function preview(string $previewId): ResponseInterface
    {
        return $this->getHttpClient()->get("/user/load_balancers/preview/{$previewId}");
    }

    /**
     * List origin health changes.
     *
     * @param array $params Query Parameters: `since`, `until`, `pool_id`, `pool_name`, `pool_healthy`, `origin_name` and `origin_healthy`.
     *
     * @return ResponseInterface List healthcheck events response
     */
    public function healthcheckEvents(array $params = []): ResponseInterface
    {
        return $this->getHttpClient()->get('/user/load_balancing_analytics/events', $params);
    }

    /**
     * User Load Balancer Monitors
     *
     * @return \Cloudflare\Endpoints\User\LoadBalancers\Monitors
     */
    public function monitors(): Monitors
    {
        return new Monitors($this->getClient());
    }

    /**
     * User Load Balancer Pools
     *
     * @return \Cloudflare\Endpoints\User\LoadBalancers\Pools
     */
    public function pools(): Pools
    {
        return new Pools($this->getClient());
    }
}
