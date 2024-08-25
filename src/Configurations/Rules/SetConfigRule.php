<?php

namespace Cloudflare\Configurations\Rules;

class SetConfigRule extends Rule
{
    /**
     * The action to perform when the rule matches. (set_config)
     * @var string
     */
    protected string $action = 'set_config';

    protected function getActionParameters(): ?array
    {

    }
}
