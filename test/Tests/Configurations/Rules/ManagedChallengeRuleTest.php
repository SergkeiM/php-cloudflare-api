<?php

namespace Cloudflare\Tests\Configurations\Rules;

use Cloudflare\Configurations\Rules\ManagedChallengeRule;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class ManagedChallengeRuleTest extends TestCase
{
    #[Test]
    public function shouldBuildArray()
    {
        $rule = new ManagedChallengeRule();

        $array = $rule->toArray();

        $this->assertSame('managed_challenge', $array['action']);
        $this->assertArrayNotHasKey('action_parameters', $array);
    }
}
