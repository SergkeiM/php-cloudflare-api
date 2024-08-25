<?php

namespace Cloudflare\Configurations\Rules;

class ExecuteRule extends Rule
{
    /**
     * The action to perform when the rule matches. (execute)
     * @var string
     */
    protected string $action = 'execute';

    protected function getActionParameters(): ?array
    {

    }
}
