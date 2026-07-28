<?php

namespace Cloudflare\Tests\Configurations\Rules;

use Cloudflare\Configurations\Rules\JSChallengeRule;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class JSChallengeRuleTest extends TestCase
{
    #[Test]
    public function shouldBuildArray()
    {
        $rule = new JSChallengeRule();

        $array = $rule->toArray();

        $this->assertSame('js_challenge', $array['action']);
        $this->assertArrayNotHasKey('action_parameters', $array);
    }
}
