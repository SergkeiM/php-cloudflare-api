<?php

namespace Cloudflare\Configurations\Rules;

class ServeErrorRule extends Rule
{
    /**
     * The action to perform when the rule matches. (serve_error)
     * @var string
     */
    protected string $action = 'serve_error';

    protected function getActionParameters(): ?array
    {

    }
}
