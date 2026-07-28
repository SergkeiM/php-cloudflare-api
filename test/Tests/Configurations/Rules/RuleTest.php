<?php

namespace Cloudflare\Tests\Configurations\Rules;

use Cloudflare\Configurations\Rules\LogRule;
use Cloudflare\ExpressionBuilder;
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
}
