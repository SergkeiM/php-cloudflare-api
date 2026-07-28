<?php

namespace Cloudflare\Tests\Configurations\Rules;

use Cloudflare\Configurations\Rules\RewriteRule;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class RewriteRuleTest extends TestCase
{
    #[Test]
    public function shouldBuildArray()
    {
        $rule = new RewriteRule();

        $array = $rule->toArray();

        $this->assertSame('rewrite', $array['action']);
        $this->assertArrayNotHasKey('action_parameters', $array);
    }
}
