<?php

namespace Cloudflare\Endpoints\ZeroTrust\Networks;

use Cloudflare\Endpoints\AbstractEndpoint;
use Cloudflare\Contracts\ResponseInterface;

class VirtualNetworks extends AbstractEndpoint
{
    /**
     * Lists and filters virtual networks in an account.
     *
     * @link https://developers.cloudflare.com/api/resources/zero_trust/subresources/networks/subresources/virtual_networks/methods/list/
     *
     * @param string $accountId Account identifier.
     * @param array $params Array containing the necessary params.
     *
     * @return \Cloudflare\Contracts\ResponseInterface List virtual networks response
     */
    public function list(string $accountId, array $params = []): ResponseInterface
    {
        return $this->getHttpClient()->get("/accounts/{$accountId}/teamnet/virtual_networks", $params);
    }

    /**
     * Adds a new virtual network to an account.
     *
     * @link https://developers.cloudflare.com/api/resources/zero_trust/subresources/networks/subresources/virtual_networks/methods/create/
     *
     * @param string $accountId Account identifier.
     * @param array $values `name` is required. `is_default` makes this the account's default virtual network, and `comment` describes it.
     *
     * @throws \Cloudflare\Exceptions\MissingArgumentException
     *
     * @return \Cloudflare\Contracts\ResponseInterface Create a virtual network response
     */
    public function create(string $accountId, array $values): ResponseInterface
    {
        $this->requiredParams(['name'], $values);

        return $this->getHttpClient()->post("/accounts/{$accountId}/teamnet/virtual_networks", $values);

    }

    /**
     * Get a virtual network.
     *
     * @link https://developers.cloudflare.com/api/resources/zero_trust/subresources/networks/subresources/virtual_networks/methods/get/
     *
     * @param string $accountId Account identifier.
     * @param string $virtualNetworkId UUID of the virtual network.
     *
     * @return \Cloudflare\Contracts\ResponseInterface A virtual network response.
     */
    public function get(string $accountId, string $virtualNetworkId): ResponseInterface
    {
        return $this->getHttpClient()->get("/accounts/{$accountId}/teamnet/virtual_networks/{$virtualNetworkId}");
    }

    /**
     * Updates an existing virtual network.
     *
     * @link https://developers.cloudflare.com/api/resources/zero_trust/subresources/networks/subresources/virtual_networks/methods/edit/
     *
     * @param string $accountId Account identifier.
     * @param string $virtualNetworkId UUID of the virtual network.
     * @param array $values he fields that are meant to be updated
     *
     * @return \Cloudflare\Contracts\ResponseInterface Update a virtual network response
     */
    public function edit(string $accountId, string $virtualNetworkId, array $values = []): ResponseInterface
    {
        return $this->getHttpClient()->patch("/accounts/{$accountId}/teamnet/virtual_networks/{$virtualNetworkId}", $values);
    }

    /**
     * Deletes an existing virtual network.
     *
     * @link https://developers.cloudflare.com/api/resources/zero_trust/subresources/networks/subresources/virtual_networks/methods/delete/
     *
     * @param string $accountId Account identifier.
     * @param string $virtualNetworkId UUID of the virtual network.
     *
     * @return \Cloudflare\Contracts\ResponseInterface Delete a virtual network response
     */
    public function delete(string $accountId, string $virtualNetworkId): ResponseInterface
    {
        return $this->getHttpClient()->delete("/accounts/{$accountId}/teamnet/virtual_networks/{$virtualNetworkId}");
    }
}
