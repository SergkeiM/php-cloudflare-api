<?php

namespace Cloudflare\Tests\Configurations\Rules;

use Cloudflare\Configurations\Rules\DDoSDynamicRule;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class DDoSDynamicRuleTest extends TestCase
{
    #[Test]
    public function shouldBuildArray()
    {
        $rule = new DDoSDynamicRule();

        $array = $rule->toArray();

        $this->assertSame('ddos_dynamic', $array['action']);
        $this->assertArrayNotHasKey('action_parameters', $array);
    }
}
