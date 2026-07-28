<?php

namespace Cloudflare\Tests\Configurations\Rules;

use Cloudflare\Configurations\Rules\ScoreRule;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class ScoreRuleTest extends TestCase
{
    #[Test]
    public function shouldBuildArray()
    {
        $rule = new ScoreRule();

        $array = $rule->toArray();

        $this->assertSame('score', $array['action']);
        $this->assertArrayNotHasKey('action_parameters', $array);
    }
}
