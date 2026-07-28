<?php

namespace Cloudflare\Tests;

use Cloudflare\ExpressionBuilder;
use Cloudflare\Exceptions\BadMethodCallException;
use Cloudflare\Exceptions\InvalidArgumentException;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class ExpressionBuilderTest extends TestCase
{
    #[Test]
    public function shouldBuildFieldWithComparisonOperator()
    {
        $builder = (new ExpressionBuilder())->field('ip.src')->eq('127.0.0.1');

        $this->assertSame('ip.src eq 127.0.0.1', $builder->build());
        $this->assertSame('ip.src eq 127.0.0.1', (string) $builder);
    }

    #[Test]
    public function shouldQuoteNonFieldNonIpStringValues()
    {
        $builder = (new ExpressionBuilder())->field('http.host')->eq('example.com');

        $this->assertSame('http.host eq "example.com"', $builder->build());
    }

    #[Test]
    public function shouldNotQuoteFieldNameValues()
    {
        $builder = (new ExpressionBuilder())->field('ip.src')->eq('ip.dst');

        $this->assertSame('ip.src eq ip.dst', $builder->build());
    }

    #[Test]
    public function shouldFormatArrayValues()
    {
        $builder = (new ExpressionBuilder())->field('ip.src')->in(['127.0.0.1', '127.0.0.2']);

        $this->assertSame('ip.src in {127.0.0.1 127.0.0.2}', $builder->build());
    }

    #[Test]
    public function shouldFormatNonStringNonArrayValues()
    {
        $builder = (new ExpressionBuilder())->field('http.request.body.size')->gt(1024);

        $this->assertSame('http.request.body.size gt 1024', $builder->build());
    }

    #[Test]
    public function shouldAddExpressionWithoutOperatorOrValue()
    {
        $builder = (new ExpressionBuilder())->addExpression('true');

        $this->assertSame('true', $builder->build());
    }

    #[Test]
    public function shouldAddLogicalOperators()
    {
        $builder = (new ExpressionBuilder())
            ->field('ip.src')->eq('127.0.0.1')
            ->and()
            ->field('ip.dst')->eq('127.0.0.2');

        $this->assertSame('ip.src eq 127.0.0.1 and ip.dst eq 127.0.0.2', $builder->build());
    }

    #[Test]
    public function shouldNegateWithNot()
    {
        $builder = (new ExpressionBuilder())->not()->field('ssl');

        $this->assertSame('not ssl', $builder->build());
    }

    #[Test]
    public function shouldGroupExpressions()
    {
        $builder = (new ExpressionBuilder())->group(function (ExpressionBuilder $b) {
            return $b->field('ip.src')->eq('127.0.0.1')->or()->field('ip.src')->eq('127.0.0.2');
        });

        $this->assertSame('ip.src eq 127.0.0.1 or ip.src eq 127.0.0.2', $builder->build());
    }

    #[Test]
    public function shouldGroupExpressionsAlongsideOthers()
    {
        $builder = (new ExpressionBuilder())
            ->field('ssl')
            ->and()
            ->group(function (ExpressionBuilder $b) {
                return $b->field('ip.src')->eq('127.0.0.1');
            });

        $this->assertSame('ssl and (ip.src eq 127.0.0.1)', $builder->build());
    }

    #[Test]
    public function shouldAddFunctionWithoutOperatorOrValue()
    {
        $builder = (new ExpressionBuilder())->addFunction('len', 'ip.src');

        $this->assertSame('len(ip.src)', $builder->build());
    }

    #[Test]
    public function shouldAddFunctionWithOperatorAndValue()
    {
        $builder = (new ExpressionBuilder())->addFunction('len', 'ip.src', 'eq', 10);

        $this->assertSame('len(ip.src) eq 10', $builder->build());
    }

    #[Test]
    public function shouldThrowOnInvalidFunctionField()
    {
        $this->expectException(InvalidArgumentException::class);

        (new ExpressionBuilder())->addFunction('len', 'not.a.real.field');
    }

    #[Test]
    public function shouldThrowOnInvalidFieldName()
    {
        $this->expectException(InvalidArgumentException::class);

        (new ExpressionBuilder())->field('not.a.real.field');
    }

    #[Test]
    public function shouldAddStrictWildcard()
    {
        $builder = (new ExpressionBuilder())->wildcard('*.example.com', true);

        $this->assertSame('strict wildcard "*.example.com"', $builder->build());
    }

    #[Test]
    public function shouldAddNonStrictWildcard()
    {
        $builder = (new ExpressionBuilder())->wildcard('*.example.com', false);

        $this->assertSame('wildcard "*.example.com"', $builder->build());
    }

    #[Test]
    public function shouldThrowOnUndefinedMethod()
    {
        $this->expectException(BadMethodCallException::class);

        (new ExpressionBuilder())->notARealMethod();
    }
}
