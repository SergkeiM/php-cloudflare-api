<?php

namespace Cloudflare\Tests\Configurations\Rules;

use Cloudflare\Configurations\Rules\ServeErrorRule;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class ServeErrorRuleTest extends TestCase
{
    #[Test]
    public function shouldBuildArray()
    {
        $rule = new ServeErrorRule();

        $array = $rule->toArray();

        $this->assertSame('serve_error', $array['action']);
        $this->assertArrayNotHasKey('action_parameters', $array);
    }
}
