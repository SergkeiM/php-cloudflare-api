<?php

namespace Cloudflare\Tests\Configurations;

use Cloudflare\Configurations\Ruleset;
use Cloudflare\Configurations\Rules\BlockRule;
use Cloudflare\Exceptions\BadMethodCallException;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class RulesetTest extends TestCase
{
    #[Test]
    public function shouldBuildMinimalArray()
    {
        $ruleset = (new Ruleset('my ruleset'))->zone()->requestFirewallCustom();

        $this->assertSame([
            'name' => 'my ruleset',
            'kind' => 'zone',
            'phase' => 'http_request_firewall_custom',
            'rules' => [],
        ], $ruleset->toArray());
    }

    #[Test]
    public function shouldSetNameAndDescription()
    {
        $ruleset = (new Ruleset('my ruleset'))
            ->setName('renamed')
            ->setDescription('an informative description')
            ->managed()
            ->ddosL4();

        $array = $ruleset->toArray();

        $this->assertSame('renamed', $array['name']);
        $this->assertSame('managed', $array['kind']);
        $this->assertSame('ddos_l4', $array['phase']);
        $this->assertSame('an informative description', $array['description']);
    }

    #[Test]
    public function shouldAddRules()
    {
        $ruleset = (new Ruleset('my ruleset'))
            ->custom()
            ->rateLimit()
            ->addRule((new BlockRule('{"error": "blocked"}'))->setExpression('true'));

        $array = $ruleset->toArray();

        $this->assertCount(1, $array['rules']);
        $this->assertSame('block', $array['rules'][0]['action']);
    }

    #[Test]
    public function shouldThrowOnUndefinedMethod()
    {
        $this->expectException(BadMethodCallException::class);

        (new Ruleset('my ruleset'))->notARealMethod();
    }
}
