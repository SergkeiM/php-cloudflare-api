<?php

namespace CloudFlare\Endpoints\Tunnel;

use CloudFlare\Endpoints\AbstractEndpoint;
use CloudFlare\Contracts\CloudFlareResponse;

class VirtualNetworks extends AbstractEndpoint
{
    /**
     * Lists and filters virtual networks in an account.
     *
     * @link https://developers.cloudflare.com/api/operations/tunnel-virtual-network-list-virtual-networks
     *
     * @param string $accountId Account identifier.
     * @param array $params Array containing the necessary params.
     *
     * @return \CloudFlare\Contracts\CloudFlareResponse List virtual networks response
     */
    public function list(string $accountId, array $params = []): CloudFlareResponse
    {
        return $this->getHttpClient()->get("/accounts/{$accountId}/teamnet/virtual_networks", $params);
    }

    /**
     * Adds a new virtual network to an account.
     *
     * @link https://developers.cloudflare.com/api/operations/tunnel-virtual-network-create-a-virtual-network
     *
     * @param string $accountId Account identifier.
     * @param string $name A user-friendly name for the virtual network.
     * @param bool $isDefault If `true`, this virtual network is the default for the account.
     * @param string $comment Optional remark describing the virtual network.
     *
     * @return \CloudFlare\Contracts\CloudFlareResponse Create a virtual network response
     */
    public function create(string $accountId, string $name, bool $isDefault = false, string $comment = null): CloudFlareResponse
    {

        $values = [
            'name' => $name,
            'is_default' => $isDefault,
        ];

        if(!is_null($comment)) {
            $values['comment'] = $comment;
        }

        return $this->getHttpClient()->post("/accounts/{$accountId}/teamnet/virtual_networks", $values);

    }

    /**
     * Get a virtual network.
     *
     * @link https://developers.cloudflare.com/api/operations/tunnel-virtual-network-get
     *
     * @param string $accountId Account identifier.
     * @param string $virtualNetworkId UUID of the virtual network.
     *
     * @return \CloudFlare\Contracts\CloudFlareResponse A virtual network response.
     */
    public function details(string $accountId, string $virtualNetworkId): CloudFlareResponse
    {
        return $this->getHttpClient()->get("/accounts/{$accountId}/teamnet/virtual_networks/{$virtualNetworkId}");
    }

    /**
     * Updates an existing virtual network.
     *
     * @link https://developers.cloudflare.com/api/operations/tunnel-virtual-network-update
     *
     * @param string $accountId Account identifier.
     * @param string $virtualNetworkId UUID of the virtual network.
     * @param array $values he fields that are meant to be updated
     *
     * @return \CloudFlare\Contracts\CloudFlareResponse Update a virtual network response
     */
    public function update(string $accountId, string $virtualNetworkId, array $values = []): CloudFlareResponse
    {
        return $this->getHttpClient()->patch("/accounts/{$accountId}/teamnet/virtual_networks/{$virtualNetworkId}", $values);
    }

    /**
     * Deletes an existing virtual network.
     *
     * @link https://developers.cloudflare.com/api/operations/tunnel-virtual-network-delete
     *
     * @param string $accountId Account identifier.
     * @param string $virtualNetworkId UUID of the virtual network.
     *
     * @return \CloudFlare\Contracts\CloudFlareResponse Delete a virtual network response
     */
    public function delete(string $accountId, string $virtualNetworkId): CloudFlareResponse
    {
        return $this->getHttpClient()->delete("/accounts/{$accountId}/teamnet/virtual_networks/{$virtualNetworkId}");
    }
}
