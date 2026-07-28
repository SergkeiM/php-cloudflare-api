<?php

namespace Cloudflare\Tests\Configurations\Rules;

use Cloudflare\Configurations\Rules\ConfigRule;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class ConfigRuleTest extends TestCase
{
    #[Test]
    public function shouldBuildArray()
    {
        $rule = new ConfigRule();

        $array = $rule->toArray();

        $this->assertSame('set_config', $array['action']);
        $this->assertSame(['ssl' => 'flexible'], $array['action_parameters']);
    }
}
