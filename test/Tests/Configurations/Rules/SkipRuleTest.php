<?php

namespace Cloudflare\Tests\Configurations\Rules;

use Cloudflare\Configurations\Rules\SkipRule;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class SkipRuleTest extends TestCase
{
    #[Test]
    public function shouldBuildArray()
    {
        $rule = new SkipRule();

        $array = $rule->toArray();

        $this->assertSame('skip', $array['action']);
        $this->assertArrayNotHasKey('action_parameters', $array);
    }

    /**
     * Logging is a rule-level field, not an action parameter, and used to be
     * dropped entirely.
     */
    #[Test]
    public function shouldEnableAndDisableLogging()
    {
        $rule = new SkipRule();

        $this->assertSame($rule, $rule->enableLogging());
        $this->assertSame(['enabled' => true], $rule->toArray()['logging']);

        $this->assertSame($rule, $rule->disableLogging());
        $this->assertSame(['enabled' => false], $rule->toArray()['logging']);
    }

    #[Test]
    public function shouldCarryWhatToSkip()
    {
        $rule = new SkipRule(['products' => ['waf', 'rateLimit']]);

        $array = $rule->toArray();

        $this->assertSame('skip', $array['action']);
        $this->assertSame(['products' => ['waf', 'rateLimit']], $array['action_parameters']);
    }

    #[Test]
    public function shouldOmitLoggingWhenNeverSet()
    {
        $this->assertArrayNotHasKey('logging', (new SkipRule())->toArray());
    }
}
