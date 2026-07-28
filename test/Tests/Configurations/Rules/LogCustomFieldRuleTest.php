<?php

namespace Cloudflare\Tests\Configurations\Rules;

use Cloudflare\Configurations\Rules\LogCustomFieldRule;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class LogCustomFieldRuleTest extends TestCase
{
    #[Test]
    public function shouldBuildArray()
    {
        $rule = new LogCustomFieldRule();

        $array = $rule->toArray();

        $this->assertSame('log_custom_field', $array['action']);
        $this->assertArrayNotHasKey('action_parameters', $array);
    }
}
