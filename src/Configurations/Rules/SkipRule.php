<?php

namespace Cloudflare\Configurations\Rules;

class SkipRule extends Rule
{
    /**
     * The action to perform when the rule matches. (skip)
     * @var string
     */
    protected string $action = 'skip';

    /**
     * Whether to generate a log when the rule matches.
     * @var bool
     */
    protected bool $logging = false;

    /**
     * Enable logging.
     * @return \Cloudflare\Configurations\Rules\Rule
     */
    public function enableLogging(): self
    {
        $this->logging = true;

        return $this;
    }

    /**
     * Disable logging.
     * @return \Cloudflare\Configurations\Rules\Rule
     */
    public function disableLogging(): self
    {
        $this->logging = false;

        return $this;
    }

    protected function getActionParameters(): ?array
    {

    }
}
