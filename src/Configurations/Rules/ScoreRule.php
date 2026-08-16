<?php

namespace Cloudflare\Configurations\Rules;

class ScoreRule extends Rule
{
    /**
     * The action to perform when the rule matches. (score)
     * @var string
     */
    protected string $action = 'score';

    /**
     * Increment the cumulative score.
     *
     * @param int $increment The amount to increment the score by.
     */
    public function __construct(
        private int $increment
    ) {
    }

    /**
     * The parameters configuring the rule's action.
     * @return ?array
     */
    protected function getActionParameters(): ?array
    {
        return [
            'increment' => $this->increment,
        ];
    }
}
