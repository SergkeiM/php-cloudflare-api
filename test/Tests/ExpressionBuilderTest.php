<?php

namespace Cloudflare\Tests;

use Cloudflare\ExpressionBuilder;
use Cloudflare\Exceptions\BadMethodCallException;
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

    /**
     * Cloudflare adds fields continually, so a name this package has not heard
     * of is passed through rather than rejected — `cf.llm.prompt.detected` is
     * a real field that predates nothing but this list.
     */
    #[Test]
    public function shouldAcceptFieldsItDoesNotKnow()
    {
        $this->assertSame(
            'cf.llm.prompt.detected eq true',
            (new ExpressionBuilder())->field('cf.llm.prompt.detected')->eq(true)->build()
        );

        $this->assertSame(
            'len(cf.api_gateway.auth_id_present) eq 10',
            (new ExpressionBuilder())->addFunction('len', 'cf.api_gateway.auth_id_present', 'eq', 10)->build()
        );
    }

    /**
     * A value naming a known field is a reference to that field, not a string
     * to compare against, which is what the field list is for.
     */
    #[Test]
    public function shouldCompareTwoFields()
    {
        $this->assertSame(
            'http.host eq http.request.uri.path',
            (new ExpressionBuilder())->field('http.host')->eq('http.request.uri.path')->build()
        );
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

    /**
     * The Rules language spells booleans out. Casting gave `1` for true and an
     * empty string for false, which is not a valid expression at all.
     */
    #[Test]
    public function shouldFormatBooleans()
    {
        $this->assertSame(
            'cf.bot_management.verified_bot eq true',
            (new ExpressionBuilder())->field('cf.bot_management.verified_bot')->eq(true)->build()
        );

        $this->assertSame(
            'cf.bot_management.verified_bot eq false',
            (new ExpressionBuilder())->field('cf.bot_management.verified_bot')->eq(false)->build()
        );
    }

    /**
     * The comparison used to be dropped whenever the value was falsy, so
     * `eq(0)` and `eq('')` produced an expression with no comparison in it.
     */
    #[Test]
    public function shouldKeepFalsyComparisonValues()
    {
        $this->assertSame(
            'cf.threat_score eq 0',
            (new ExpressionBuilder())->field('cf.threat_score')->eq(0)->build()
        );

        $this->assertSame(
            'http.user_agent eq ""',
            (new ExpressionBuilder())->field('http.user_agent')->eq('')->build()
        );
    }
}
