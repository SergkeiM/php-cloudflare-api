<?php

namespace Cloudflare\Configurations\Rules;

class RewriteRule extends Rule
{
    /**
     * The action to perform when the rule matches. (rewrite)
     * @var string
     */
    protected string $action = 'rewrite';

    protected function getActionParameters(): ?array
    {

    }
}
