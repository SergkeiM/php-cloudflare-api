<?php

namespace Cloudflare\Configurations\Rules;

class RedirectRule extends Rule
{
    /**
     * The action to perform when the rule matches. (redirect)
     * @var string
     */
    protected string $action = 'redirect';

    protected function getActionParameters(): ?array
    {

    }
}
