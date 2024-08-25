<?php

namespace Cloudflare\Configurations\Rules;

class ForceConnectionCloseRule extends Rule
{
    /**
     * The action to perform when the rule matches. (force_connection_close)
     * @var string
     */
    protected string $action = 'force_connection_close';

    /**
     * The parameters configuring the rule's action.
     * @return ?array
     */
    protected function getActionParameters(): ?array
    {
        return null;
    }
}
