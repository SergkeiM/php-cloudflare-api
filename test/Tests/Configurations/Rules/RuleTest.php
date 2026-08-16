<?php

namespace Cloudflare\Tests\Configurations\Rules;

use Cloudflare\Configurations\Rules\LogRule;
use Cloudflare\ExpressionBuilder;
use Cloudflare\Configurations\Rules\RedirectRule;
use Cloudflare\Configurations\Rules\RewriteRule;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class RuleTest extends TestCase
{
    #[Test]
    public function shouldBuildMinimalArray()
    {
        $rule = new LogRule();

        $this->assertSame([
            'action' => 'log',
            'enabled' => false,
            'expression' => true,
        ], $rule->toArray());
    }

    #[Test]
    public function shouldEnableAndDisable()
    {
        $rule = (new LogRule())->enable();
        $this->assertTrue($rule->toArray()['enabled']);

        $rule->disable();
        $this->assertFalse($rule->toArray()['enabled']);
    }

    #[Test]
    public function shouldSetDescriptionIdAndRef()
    {
        $rule = (new LogRule())
            ->setDescription('my description')
            ->setId('rule_id')
            ->setRef('rule_ref');

        $array = $rule->toArray();

        $this->assertSame('my description', $array['description']);
        $this->assertSame('rule_id', $array['id']);
        $this->assertSame('rule_ref', $array['ref']);
    }

    #[Test]
    public function shouldSetExpressionFromString()
    {
        $rule = (new LogRule())->setExpression('ip.src eq 127.0.0.1');

        $this->assertSame('ip.src eq 127.0.0.1', $rule->toArray()['expression']);
    }

    #[Test]
    public function shouldSetExpressionFromExpressionBuilder()
    {
        $builder = (new ExpressionBuilder())->field('ip.src')->eq('127.0.0.1');

        $rule = (new LogRule())->setExpression($builder);

        $this->assertSame((string) $builder, $rule->toArray()['expression']);
    }

    #[Test]
    public function shouldSetExpressionFromClosure()
    {
        $rule = (new LogRule())->setExpression(function (ExpressionBuilder $builder) {
            return $builder->field('ip.src')->eq('127.0.0.1');
        });

        $this->assertSame('ip.src eq 127.0.0.1', $rule->toArray()['expression']);
    }

    /**
     * Most actions take parameters Cloudflare defines per action and extends
     * over time, so they are set on the rule rather than modelled per class.
     */
    #[Test]
    public function shouldCarryActionParameters()
    {
        $rule = (new RedirectRule())->setActionParameters([
            'from_value' => [
                'status_code' => 301,
                'target_url' => ['value' => 'https://example.com/new'],
            ],
        ]);

        $array = $rule->toArray();

        $this->assertSame('redirect', $array['action']);
        $this->assertSame([
            'from_value' => [
                'status_code' => 301,
                'target_url' => ['value' => 'https://example.com/new'],
            ],
        ], $array['action_parameters']);
    }

    #[Test]
    public function shouldMergeRepeatedActionParameters()
    {
        $rule = (new RewriteRule())
            ->setActionParameters(['uri' => ['path' => ['value' => '/a']]])
            ->setActionParameters(['headers' => ['x-test' => ['operation' => 'set', 'value' => '1']]]);

        $this->assertSame(['uri', 'headers'], array_keys($rule->toArray()['action_parameters']));
    }

    /**
     * An action that genuinely takes no parameters still sends none.
     */
    #[Test]
    public function shouldOmitActionParametersWhenThereAreNone()
    {
        $this->assertArrayNotHasKey('action_parameters', (new LogRule())->toArray());
    }

    #[Test]
    public function shouldSetLoggingOnAnyRule()
    {
        $rule = (new LogRule())->setLogging(true);

        $this->assertSame(['enabled' => true], $rule->toArray()['logging']);
    }
}
