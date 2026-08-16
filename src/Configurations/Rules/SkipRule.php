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
     * Skip one or more of Cloudflare's own rules or products.
     *
     * What to skip is action-specific — `ruleset`, `rulesets`, `phases`,
     * `products` or `rules` — so it is passed through as given.
     *
     * ```php
     * new SkipRule(['products' => ['waf', 'rateLimit']]);
     * new SkipRule(['ruleset' => 'current']);
     * ```
     *
     * @param array $skip What the rule should skip.
     */
    public function __construct(
        private array $skip = []
    ) {
    }

    /**
     * Generate a log when the rule matches.
     * @return \Cloudflare\Configurations\Rules\SkipRule
     */
    public function enableLogging(): self
    {
        $this->setLogging(true);

        return $this;
    }

    /**
     * Do not generate a log when the rule matches.
     * @return \Cloudflare\Configurations\Rules\SkipRule
     */
    public function disableLogging(): self
    {
        $this->setLogging(false);

        return $this;
    }

    /**
     * The parameters configuring the rule's action.
     * @return ?array
     */
    protected function getActionParameters(): ?array
    {
        return $this->skip;
    }
}
