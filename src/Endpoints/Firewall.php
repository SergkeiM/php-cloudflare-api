<?php

namespace Cloudflare\Endpoints;

use Cloudflare\Endpoints\Firewall\AccessRules;
use Cloudflare\Endpoints\Firewall\Lockdowns;
use Cloudflare\Endpoints\Firewall\UaRules;

/**
 * The firewall tools Cloudflare groups together: IP Access rules, Zone Lockdown
 * and User Agent Blocking.
 *
 * @link https://developers.cloudflare.com/waf/
 */
class Firewall extends AbstractEndpoint
{
    /**
     * IP Access Rules for a zone
     *
     * Account-wide and user-wide rules live at `$client->accounts()->accessRules()`
     * and `$client->user()->accessRules()`.
     *
     * @return \Cloudflare\Endpoints\Firewall\AccessRules
     */
    public function accessRules(): AccessRules
    {
        return new AccessRules($this->getClient());
    }

    /**
     * Zone Lockdown rules
     *
     * @return \Cloudflare\Endpoints\Firewall\Lockdowns
     */
    public function lockdowns(): Lockdowns
    {
        return new Lockdowns($this->getClient());
    }

    /**
     * User Agent Blocking rules
     *
     * @return \Cloudflare\Endpoints\Firewall\UaRules
     */
    public function uaRules(): UaRules
    {
        return new UaRules($this->getClient());
    }
}
