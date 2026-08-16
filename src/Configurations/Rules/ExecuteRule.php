<?php

namespace Cloudflare\Configurations\Rules;

class ExecuteRule extends Rule
{
    /**
     * The action to perform when the rule matches. (execute)
     * @var string
     */
    protected string $action = 'execute';

    /**
     * Execute another ruleset.
     *
     * Cloudflare requires the ruleset to run; `overrides` and `matched_data`
     * are optional and go through `setActionParameters()`.
     *
     * @param string $rulesetId The ID of the ruleset to execute.
     */
    public function __construct(
        private string $rulesetId
    ) {
    }

    /**
     * The parameters configuring the rule's action.
     * @return ?array
     */
    protected function getActionParameters(): ?array
    {
        return [
            'id' => $this->rulesetId,
        ];
    }
}
