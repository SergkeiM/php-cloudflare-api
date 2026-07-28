<?php

namespace Cloudflare\Tests\Configurations\Rules;

use Cloudflare\Configurations\Rules\CacheSettingsRule;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class CacheSettingsRuleTest extends TestCase
{
    #[Test]
    public function shouldBuildArray()
    {
        $rule = new CacheSettingsRule();

        $array = $rule->toArray();

        $this->assertSame('set_cache_settings', $array['action']);
        $this->assertArrayNotHasKey('action_parameters', $array);
    }
}
