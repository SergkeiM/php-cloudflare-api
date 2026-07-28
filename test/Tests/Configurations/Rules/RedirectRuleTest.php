<?php

namespace Cloudflare\Tests\Configurations\Rules;

use Cloudflare\Configurations\Rules\RedirectRule;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class RedirectRuleTest extends TestCase
{
    #[Test]
    public function shouldBuildArray()
    {
        $rule = new RedirectRule();

        $array = $rule->toArray();

        $this->assertSame('redirect', $array['action']);
        $this->assertArrayNotHasKey('action_parameters', $array);
    }
}
