# Expression Builder

> Build expressions for the Cloudflare Rules language fluently instead of hand-writing expression strings.

## Usage

Expression builder for Cloudflare [Rules language](https://developers.cloudflare.com/ruleset-engine/rules-language/).

```php [php]
use Cloudflare\ExpressionBuilder;

$expression = (new ExpressionBuilder())
    ->field('ip.src')
    ->eq('127.0.0.1')
    ->build();

echo $expression;

// ip.src eq 127.0.0.1
```

Field names are not checked against a list. Cloudflare adds fields continually, so
anything you pass is written through and Cloudflare validates the expression itself.

The fields this package does know by name are used for something else: a value that
names one is treated as a reference to that field rather than as a string, so two
fields can be compared.

```php [php]
echo (new ExpressionBuilder())
    ->field('http.host')
    ->eq('http.request.uri.path')
    ->build();

// http.host eq http.request.uri.path
```

## Grouping

The Rules language supports parentheses (`(`,`)`) as grouping symbols. Grouping symbols allow you to organize expressions, enforce precedence, and nest expressions.

```php [php]
use Cloudflare\ExpressionBuilder;

$expression = (new ExpressionBuilder())
    ->field('ip.src')
    ->eq('127.0.0.1')
    ->or()
    ->group(function(ExpressionBuilder $builder){
        $builder->not()->field('ssl')->or()->field('ip.src.country')->eq('GB');
    })
    ->build();

echo $expression;

// ip.src eq 127.0.0.1 or (not ssl or ip.src.country eq "GB")
```

## Functions

The Cloudflare Rules language provides functions for manipulating and validating values in an expression.

```php [php]
use Cloudflare\ExpressionBuilder;

$expression = (new ExpressionBuilder())
    ->addFunction('lower', 'ip.src.country')
    ->eq('gb')
    ->build();

echo $expression;

// lower(ip.src.country) eq "gb"
```

## Wildcards

`wildcard()` matches a field against a literal containing `*` metacharacters. It is case-insensitive; pass `true` for the strict form, which is not.

```php [php]
use Cloudflare\ExpressionBuilder;

echo (new ExpressionBuilder())
    ->field('http.request.uri.path')
    ->wildcard('/api/*', false)
    ->build();

// http.request.uri.path wildcard "/api/*"

echo (new ExpressionBuilder())
    ->field('http.request.uri.path')
    ->wildcard('/API/*', true)
    ->build();

// http.request.uri.path strict wildcard "/API/*"
```

## Using an expression on a rule

Rules take a builder directly, or a closure that is handed one, so an expression can be written inline:

```php [php]
use Cloudflare\Configurations\Rules\BlockRule;

$rule = (new BlockRule('{"error": "blocked"}'))
    ->enable()
    ->setExpression(fn ($builder) => $builder->field('ip.src')->eq('203.0.113.4'));
```

See [Rules](/advanced/configurations/rules) for what else a rule can do.

## Raw expressions

`addExpression()` writes an expression straight out, without going through `field()`
and the operator methods:

```php [php]
use Cloudflare\ExpressionBuilder;

$expression = (new ExpressionBuilder())
    ->addExpression('ip.src.country', 'eq', 'GB')
    ->build();

echo $expression;

// ip.src.country eq "GB"
```

`ExpressionBuilder` implements `Stringable` so you can simply do:

```php [php]
use Cloudflare\ExpressionBuilder;

$expression = (string) (new ExpressionBuilder())
    ->addExpression('ip.src.country', 'eq', 'GB');

echo $expression;

// ip.src.country eq "GB"
```
