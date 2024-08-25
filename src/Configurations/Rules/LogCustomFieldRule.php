<?php

namespace Cloudflare\Configurations\Rules;

class LogCustomFieldRule extends Rule
{
    /**
     * The action to perform when the rule matches. (log_custom_field)
     * @var string
     */
    protected string $action = 'log_custom_field';

    protected function getActionParameters(): ?array
    {

    }
}
