<?php

namespace Cloudflare\Endpoints\Organizations;

use Cloudflare\Endpoints\AbstractEndpoint;
use Cloudflare\Endpoints\Organizations\Logs\Audit;

class Logs extends AbstractEndpoint
{
    /**
     * Organization Audit Logs
     *
     * @return \Cloudflare\Endpoints\Organizations\Logs\Audit
     */
    public function audit(): Audit
    {
        return new Audit($this->getClient());
    }
}
