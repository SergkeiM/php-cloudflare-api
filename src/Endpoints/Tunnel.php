<?php

namespace Cloudflare\Endpoints;

use Cloudflare\Endpoints\Tunnel\Routes;
use Cloudflare\Endpoints\Tunnel\VirtualNetworks;

class Tunnel extends AbstractEndpoint
{
    /**
     * Tunnel routing
     *
     * @return \Cloudflare\Endpoints\Tunnel\Routes
     */
    public function routes(): Routes
    {
        return new Routes($this->getClient());
    }

    /**
     * Tunnel virtual networks
     * @return \Cloudflare\Endpoints\Tunnel\VirtualNetworks
     */
    public function virtualNetworks(): VirtualNetworks
    {
        return new VirtualNetworks($this->getClient());
    }
}
