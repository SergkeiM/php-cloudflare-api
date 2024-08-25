<?php

namespace Cloudflare\Configurations\Rules;

class LogRule extends Rule
{
    /**
     * The action to perform when the rule matches. (log)
     * @var string
     */
    protected string $action = 'log';

    /**
     * The parameters configuring the rule's action.
     * @return ?array
     */
    protected function getActionParameters(): ?array
    {
        return null;
    }
}
