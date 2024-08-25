<?php

namespace Cloudflare\Configurations\Rules;

class ScoreRule extends Rule
{
    /**
     * The action to perform when the rule matches. (score)
     * @var string
     */
    protected string $action = 'score';

    protected function getActionParameters(): ?array
    {

    }
}
