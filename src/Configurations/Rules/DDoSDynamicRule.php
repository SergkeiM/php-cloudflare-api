<?php

namespace Cloudflare\Configurations\Rules;

class DDoSDynamicRule extends Rule
{
    /**
     * The action to perform when the rule matches. (ddos_dynamic)
     * @var string
     */
    protected string $action = 'ddos_dynamic';

    /**
     * The parameters configuring the rule's action.
     * @return ?array
     */
    protected function getActionParameters(): ?array
    {
        return null;
    }
}
