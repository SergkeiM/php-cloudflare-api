<?php

namespace Cloudflare\Tests\Configurations\Rules;

use Cloudflare\Configurations\Rules\ForceConnectionCloseRule;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class ForceConnectionCloseRuleTest extends TestCase
{
    #[Test]
    public function shouldBuildArray()
    {
        $rule = new ForceConnectionCloseRule();

        $array = $rule->toArray();

        $this->assertSame('force_connection_close', $array['action']);
        $this->assertArrayNotHasKey('action_parameters', $array);
    }
}
