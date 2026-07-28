<?php

namespace Cloudflare\Tests\Configurations\Rules;

use Cloudflare\Configurations\Rules\ChallengeRule;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class ChallengeRuleTest extends TestCase
{
    #[Test]
    public function shouldBuildArray()
    {
        $rule = new ChallengeRule();

        $array = $rule->toArray();

        $this->assertSame('challenge', $array['action']);
        $this->assertArrayNotHasKey('action_parameters', $array);
    }
}
