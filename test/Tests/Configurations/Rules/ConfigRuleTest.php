<?php

namespace Cloudflare\Tests\Configurations\Rules;

use Cloudflare\Configurations\Rules\ConfigRule;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class ConfigRuleTest extends TestCase
{
    #[Test]
    public function shouldBuildArray()
    {
        $rule = new ConfigRule(['ssl' => 'full', 'automatic_https_rewrites' => true]);

        $array = $rule->toArray();

        $this->assertSame('set_config', $array['action']);
        $this->assertSame([
            'ssl' => 'full',
            'automatic_https_rewrites' => true,
        ], $array['action_parameters']);
    }

    /**
     * A rule with no settings sends no action parameters, rather than a
     * hardcoded default the caller never asked for.
     */
    #[Test]
    public function shouldSendNoParametersWhenGivenNoSettings()
    {
        $array = (new ConfigRule())->toArray();

        $this->assertArrayNotHasKey('action_parameters', $array);
    }
}
