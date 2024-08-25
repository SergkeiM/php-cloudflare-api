<?php

namespace Cloudflare\Configurations\Rules;

class SkipRule extends Rule
{
    /**
     * The action to perform when the rule matches. (skip)
     * @var string
     */
    protected string $action = 'skip';

    protected function getActionParameters(): ?array
    {

    }
}
