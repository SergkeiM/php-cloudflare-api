<?php

namespace Cloudflare\Tests\Configurations\Rules;

use Cloudflare\Configurations\Rules\LogRule;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class LogRuleTest extends TestCase
{
    #[Test]
    public function shouldBuildArray()
    {
        $rule = new LogRule();

        $array = $rule->toArray();

        $this->assertSame('log', $array['action']);
        $this->assertArrayNotHasKey('action_parameters', $array);
    }
}
