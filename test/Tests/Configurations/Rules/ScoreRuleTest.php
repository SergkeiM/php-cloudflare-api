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
        $rule = new ScoreRule(20);

        $array = $rule->toArray();

        $this->assertSame('score', $array['action']);
        $this->assertSame(['increment' => 20], $array['action_parameters']);
    }
}
