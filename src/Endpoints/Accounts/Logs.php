<?php

namespace Cloudflare\Endpoints\Accounts;

use Cloudflare\Endpoints\AbstractEndpoint;
use Cloudflare\Endpoints\Accounts\Logs\Audit;

class Logs extends AbstractEndpoint
{
    /**
     * Account Audit Logs
     *
     * @return \Cloudflare\Endpoints\Accounts\Logs\Audit
     */
    public function audit(): Audit
    {
        return new Audit($this->getClient());
    }
}
