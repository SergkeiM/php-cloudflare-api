<?php

namespace Cloudflare\Endpoints\Tunnel;

use Cloudflare\Endpoints\AbstractEndpoint;
use Cloudflare\Contracts\ResponseInterface;

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
     * @return \Cloudflare\Contracts\ResponseInterface List virtual networks response
     */
    public function list(string $accountId, array $params = []): ResponseInterface
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
     * @return \Cloudflare\Contracts\ResponseInterface Create a virtual network response
     */
    public function create(string $accountId, string $name, bool $isDefault = false, string $comment = null): ResponseInterface
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
     * @return \Cloudflare\Contracts\ResponseInterface A virtual network response.
     */
    public function details(string $accountId, string $virtualNetworkId): ResponseInterface
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
     * @return \Cloudflare\Contracts\ResponseInterface Update a virtual network response
     */
    public function update(string $accountId, string $virtualNetworkId, array $values = []): ResponseInterface
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
     * @return \Cloudflare\Contracts\ResponseInterface Delete a virtual network response
     */
    public function delete(string $accountId, string $virtualNetworkId): ResponseInterface
    {
        return $this->getHttpClient()->delete("/accounts/{$accountId}/teamnet/virtual_networks/{$virtualNetworkId}");
    }
}
