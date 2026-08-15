<?php

namespace Cloudflare\Endpoints\ZeroTrust;

use Cloudflare\Endpoints\AbstractEndpoint;
use Cloudflare\Endpoints\ZeroTrust\Networks\Routes;
use Cloudflare\Endpoints\ZeroTrust\Networks\VirtualNetworks;

/**
 * The private network reachable through Cloudflare Tunnel: the routes that say
 * which CIDRs a tunnel serves, and the virtual networks that let overlapping
 * ranges coexist.
 *
 * @link https://developers.cloudflare.com/cloudflare-one/networks/
 */
class Networks extends AbstractEndpoint
{
    /**
     * Tunnel Routes
     *
     * @return \Cloudflare\Endpoints\ZeroTrust\Networks\Routes
     */
    public function routes(): Routes
    {
        return new Routes($this->getClient());
    }

    /**
     * Tunnel Virtual Networks
     *
     * @return \Cloudflare\Endpoints\ZeroTrust\Networks\VirtualNetworks
     */
    public function virtualNetworks(): VirtualNetworks
    {
        return new VirtualNetworks($this->getClient());
    }
}
