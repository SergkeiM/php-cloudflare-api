<?php

namespace Cloudflare\Endpoints\Organizations;

use Cloudflare\Endpoints\AbstractEndpoint;
use Cloudflare\Endpoints\Organizations\Billing\Usage;

class Billing extends AbstractEndpoint
{
    /**
     * Organization Billing Usage
     *
     * @return \Cloudflare\Endpoints\Organizations\Billing\Usage
     */
    public function usage(): Usage
    {
        return new Usage($this->getClient());
    }
}
