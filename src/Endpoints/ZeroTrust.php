<?php

namespace Cloudflare\Endpoints;

use Cloudflare\Endpoints\ZeroTrust\Networks;

/**
 * Cloudflare Zero Trust.
 *
 * Only the tunnel networking endpoints are wrapped so far; the rest of Zero
 * Trust — Access, Gateway, devices — is not covered by this package yet.
 *
 * @link https://developers.cloudflare.com/cloudflare-one/
 */
class ZeroTrust extends AbstractEndpoint
{
    /**
     * Zero Trust Networks
     *
     * @return \Cloudflare\Endpoints\ZeroTrust\Networks
     */
    public function networks(): Networks
    {
        return new Networks($this->getClient());
    }
}
