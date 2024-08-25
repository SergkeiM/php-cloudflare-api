<?php

namespace Cloudflare\Configurations\Rules;

class JSChallengeRule extends Rule
{
    /**
     * The action to perform when the rule matches. (js_challenge)
     * @var string
     */
    protected string $action = 'js_challenge';

    /**
     * The parameters configuring the rule's action.
     * @return ?array
     */
    protected function getActionParameters(): ?array
    {
        return null;
    }
}
