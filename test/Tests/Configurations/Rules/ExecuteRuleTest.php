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
        $rule = new ExecuteRule();

        $array = $rule->toArray();

        $this->assertSame('execute', $array['action']);
        $this->assertArrayNotHasKey('action_parameters', $array);
    }
}
