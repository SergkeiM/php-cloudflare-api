<?php

namespace Cloudflare\Configurations\Rules;

class OriginRule extends Rule
{
    /**
     * The action to perform when the rule matches. (route)
     * @var string
     */
    protected string $action = 'route';

    protected function getActionParameters(): ?array
    {

    }
}
