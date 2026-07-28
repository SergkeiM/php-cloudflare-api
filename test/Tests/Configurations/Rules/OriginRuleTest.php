<?php

namespace Cloudflare\Tests\Configurations\Rules;

use Cloudflare\Configurations\Rules\OriginRule;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class OriginRuleTest extends TestCase
{
    #[Test]
    public function shouldBuildArray()
    {
        $rule = new OriginRule();

        $array = $rule->toArray();

        $this->assertSame('route', $array['action']);
        $this->assertArrayNotHasKey('action_parameters', $array);
    }
}
