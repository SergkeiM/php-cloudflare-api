<?php

namespace CloudFlare\Endpoints;

use CloudFlare\Endpoints\Tunnel\Routes;
use CloudFlare\Endpoints\Tunnel\VirtualNetworks;

class Tunnel extends AbstractEndpoint
{
    /**
     * Tunnel routing
     *
     * @return \CloudFlare\Endpoints\Tunnel\Routes
     */
    public function routes(): Routes
    {
        return new Routes($this->getClient());
    }

    /**
     * Tunnel virtual networks
     * @return \CloudFlare\Endpoints\Tunnel\VirtualNetworks
     */
    public function virtualNetworks(): VirtualNetworks
    {
        return new VirtualNetworks($this->getClient());
    }
}
