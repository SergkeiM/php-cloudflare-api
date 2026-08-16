<?php

namespace Cloudflare\Tests\Configurations\Rules;

use Cloudflare\Configurations\Rules\ExecuteRule;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class ExecuteRuleTest extends TestCase
{
    #[Test]
    public function shouldBuildArray()
    {
        $rule = new ExecuteRule('ruleset_id');

        $array = $rule->toArray();

        $this->assertSame('execute', $array['action']);
        $this->assertSame(['id' => 'ruleset_id'], $array['action_parameters']);
    }

    /**
     * Cloudflare requires the ruleset id, and takes overrides alongside it.
     */
    #[Test]
    public function shouldCarryOverrides()
    {
        $rule = (new ExecuteRule('ruleset_id'))->setActionParameters([
            'overrides' => ['enabled' => false],
        ]);

        $this->assertSame([
            'id' => 'ruleset_id',
            'overrides' => ['enabled' => false],
        ], $rule->toArray()['action_parameters']);
    }
}
