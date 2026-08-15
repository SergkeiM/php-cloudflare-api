<?php

namespace Cloudflare\Endpoints\ZeroTrust\Networks;

use Cloudflare\Endpoints\AbstractEndpoint;
use Cloudflare\Contracts\ResponseInterface;

class Routes extends AbstractEndpoint
{
    /**
     * Lists and filters private network routes in an account.
     *
     * @link https://developers.cloudflare.com/api/resources/zero_trust/subresources/networks/subresources/routes/methods/list/
     *
     * @param string $accountId Account identifier.
     * @param array $params Array containing the necessary params.
     *
     * @return \Cloudflare\Contracts\ResponseInterface List tunnel routes response
     */
    public function list(string $accountId, array $params = []): ResponseInterface
    {
        return $this->getHttpClient()->get("/accounts/{$accountId}/teamnet/routes", $params);
    }

    /**
     * Fetches routes that contain the given IP address.
     *
     * @link https://developers.cloudflare.com/api/resources/zero_trust/subresources/networks/subresources/routes/subresources/ips/methods/get/
     *
     * @param string $accountId Account identifier.
     * @param string $ip IP
     * @param string $virtualNetworkId UUID of the virtual network.
     *
     * @return \Cloudflare\Contracts\ResponseInterface Get tunnel route by IP response
     */
    public function getByIP(string $accountId, string $ip, ?string $virtualNetworkId = null): ResponseInterface
    {

        $params = [];

        if (!is_null($virtualNetworkId)) {
            $params['virtual_network_id'] = $virtualNetworkId;
        }

        return $this->getHttpClient()->get("/accounts/{$accountId}/teamnet/routes/ip/{$ip}", $params);
    }

    /**
     * Routes a private network through a Cloudflare Tunnel.
     *
     * @link https://developers.cloudflare.com/api/resources/zero_trust/subresources/networks/subresources/routes/methods/create/
     *
     * @param string $accountId Account identifier.
     * @param string $network The private IPv4 or IPv6 range connected by the route, in CIDR notation.
     * @param string $virtualNetworkId UUID of the virtual network.
     * @param string $comment Optional remark describing the route.
     *
     * @return \Cloudflare\Contracts\ResponseInterface Create a tunnel route response
     */
    public function create(string $accountId, string $network, ?string $virtualNetworkId = null, ?string $comment = null): ResponseInterface
    {

        $values = [
            'network' => $network,
        ];

        if (!is_null($virtualNetworkId)) {
            $values['virtual_network_id'] = $virtualNetworkId;
        }

        if (!is_null($comment)) {
            $values['comment'] = $comment;
        }

        return $this->getHttpClient()->post("/accounts/{$accountId}/teamnet/routes", $values);

    }

    /**
     * Get a private network route in an account.
     *
     * @link https://developers.cloudflare.com/api/resources/zero_trust/subresources/networks/subresources/routes/methods/get/
     *
     * @param string $accountId Account identifier.
     * @param string $routeId UUID of the route.
     *
     * @return \Cloudflare\Contracts\ResponseInterface Get a tunnel route response
     */
    public function get(string $accountId, string $routeId): ResponseInterface
    {
        return $this->getHttpClient()->get("/accounts/{$accountId}/teamnet/routes/{$routeId}");
    }

    /**
     * Updates an existing private network route in an account.
     *
     * @link https://developers.cloudflare.com/api/resources/zero_trust/subresources/networks/subresources/routes/methods/edit/
     * @param string $accountId Account identifier.
     * @param string $routeId UUID of the route.
     * @param array $values The fields that are meant to be updated
     *
     * @return \Cloudflare\Contracts\ResponseInterface Update a tunnel route response
     */
    public function edit(string $accountId, string $routeId, array $values = []): ResponseInterface
    {
        return $this->getHttpClient()->patch("/accounts/{$accountId}/teamnet/routes/{$routeId}", $values);
    }

    /**
     * Deletes a private network route from an account.
     *
     * @link https://developers.cloudflare.com/api/resources/zero_trust/subresources/networks/subresources/routes/methods/delete/
     *
     * @param string $accountId Account identifier.
     * @param string $routeId UUID of the route.
     *
     * @return \Cloudflare\Contracts\ResponseInterface Delete a tunnel route response
     */
    public function delete(string $accountId, string $routeId): ResponseInterface
    {
        return $this->getHttpClient()->delete("/accounts/{$accountId}/teamnet/routes/{$routeId}");
    }
}
