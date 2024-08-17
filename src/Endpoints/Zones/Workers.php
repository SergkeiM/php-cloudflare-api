<?php

namespace SergkeiM\CloudFlare\Endpoints\Zones;

use SergkeiM\CloudFlare\Endpoints\AbstractEndpoint;
use SergkeiM\CloudFlare\Endpoints\Zones\Workers\Routes;

class Workers extends AbstractEndpoint
{
    /**
     * Worker Zone Routes
     *
     * @return Routes
     */
    public function routes(): Routes
    {
        return new Routes($this->getClient());
    }
}
