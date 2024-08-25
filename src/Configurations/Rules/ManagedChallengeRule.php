<?php

namespace Cloudflare\Configurations\Rules;

class ManagedChallengeRule extends Rule
{
    /**
     * The action to perform when the rule matches. (challenge)
     * @var string
     */
    protected string $action = 'managed_challenge';

    /**
     * The parameters configuring the rule's action.
     * @return ?array
     */
    protected function getActionParameters(): ?array
    {
        return null;
    }
}
