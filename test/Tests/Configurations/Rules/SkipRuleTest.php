<?php

namespace Cloudflare\Tests\Configurations\Rules;

use Cloudflare\Configurations\Rules\SkipRule;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class SkipRuleTest extends TestCase
{
    #[Test]
    public function shouldBuildArray()
    {
        $rule = new SkipRule();

        $array = $rule->toArray();

        $this->assertSame('skip', $array['action']);
        $this->assertArrayNotHasKey('action_parameters', $array);
    }

    #[Test]
    public function shouldEnableAndDisableLogging()
    {
        $rule = new SkipRule();

        $this->assertSame($rule, $rule->enableLogging());
        $this->assertSame($rule, $rule->disableLogging());
    }
}
