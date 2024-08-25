<?php

namespace Cloudflare;

use Cloudflare\Exceptions\InvalidArgumentException;
use Cloudflare\Exceptions\BadMethodCallException;
use Closure;
use Stringable;

/**
 * @method \Cloudflare\ExpressionBuilder eq() eq(mixed $value)
 * @method \Cloudflare\ExpressionBuilder equal() equal(mixed $value) Alias to eq()
 * @method \Cloudflare\ExpressionBuilder ne() ne(mixed $value)
 * @method \Cloudflare\ExpressionBuilder notEqual() notEqual(mixed $value) Alias to ne()
 * @method \Cloudflare\ExpressionBuilder lt() lt(mixed $value)
 * @method \Cloudflare\ExpressionBuilder lessThan() lessThan(mixed $value) Alias to lessThan()
 * @method \Cloudflare\ExpressionBuilder le() le(mixed $value)
 * @method \Cloudflare\ExpressionBuilder lessThanOrEqual() lessThanOrEqual(mixed $value) Alias to le()
 * @method \Cloudflare\ExpressionBuilder gt() gt(mixed $value)
 * @method \Cloudflare\ExpressionBuilder greaterThan() greaterThan(mixed $value) Alias to gt()
 * @method \Cloudflare\ExpressionBuilder ge() ge(mixed $value)
 * @method \Cloudflare\ExpressionBuilder greaterThanOrEqual() greaterThanOrEqual(mixed $value) Alias to ge()
 * @method \Cloudflare\ExpressionBuilder contains() contains(mixed $value)
 * @method \Cloudflare\ExpressionBuilder matches() matches(mixed $value)
 * @method \Cloudflare\ExpressionBuilder in() in(mixed $value)
 *
 * @method \Cloudflare\ExpressionBuilder not() not()
 * @method \Cloudflare\ExpressionBuilder and() and()
 * @method \Cloudflare\ExpressionBuilder or() or()
 */
class ExpressionBuilder implements Stringable
{
    /**
     * Available fields
     * @var array[]
     */
    private array $fields = [
        "cf.bot_management.detection_ids",
        "cf.bot_management.ja3_hash",
        "cf.bot_management.ja4",
        "cf.bot_management.js_detection.passed",
        "cf.bot_management.score",
        "cf.bot_management.static_resource",
        "cf.bot_management.verified_bot",
        "cf.client.bot",
        "cf.colo.name",
        "cf.colo.region",
        "cf.edge.server_ip",
        "cf.edge.server_port",
        "cf.hostname.metadata",
        "cf.random_seed",
        "cf.ray_id",
        "cf.response.1xxx_code",
        "cf.response.error_type",
        "cf.threat_score",
        "cf.tls_cipher",
        "cf.tls_client_auth.cert_fingerprint_sha1",
        "cf.tls_client_auth.cert_fingerprint_sha256",
        "cf.tls_client_auth.cert_issuer_dn",
        "cf.tls_client_auth.cert_issuer_dn_legacy",
        "cf.tls_client_auth.cert_issuer_dn_rfc2253",
        "cf.tls_client_auth.cert_issuer_serial",
        "cf.tls_client_auth.cert_issuer_ski",
        "cf.tls_client_auth.cert_not_after",
        "cf.tls_client_auth.cert_not_before",
        "cf.tls_client_auth.cert_presented",
        "cf.tls_client_auth.cert_revoked",
        "cf.tls_client_auth.cert_serial",
        "cf.tls_client_auth.cert_ski",
        "cf.tls_client_auth.cert_subject_dn_legacy",
        "cf.tls_client_auth.cert_subject_dn_rfc2253",
        "cf.tls_client_auth.cert_verified",
        "cf.tls_client_extensions_sha1",
        "cf.tls_client_hello_length",
        "cf.tls_client_random",
        "cf.tls_version",
        "cf.verified_bot_category",
        "cf.waf.content_scan.has_failed",
        "cf.waf.content_scan.has_malicious_obj",
        "cf.waf.content_scan.has_obj",
        "cf.waf.content_scan.num_malicious_obj",
        "cf.waf.content_scan.num_obj",
        "cf.waf.content_scan.obj_results",
        "cf.waf.content_scan.obj_sizes",
        "cf.waf.content_scan.obj_types",
        "cf.waf.score",
        "cf.waf.score.class",
        "cf.waf.score.rce",
        "cf.waf.score.sqli",
        "cf.waf.score.xss",
        "cf.worker.upstream_zone",
        "http.cookie",
        "http.host",
        "http.referer",
        "http.request.accepted_languages",
        "http.request.body.form",
        "http.request.body.form.names",
        "http.request.body.form.values",
        "http.request.body.mime",
        "http.request.body.raw",
        "http.request.body.size",
        "http.request.body.truncated",
        "http.request.cookies",
        "http.request.full_uri",
        "http.request.headers",
        "http.request.headers.names",
        "http.request.headers.truncated",
        "http.request.headers.values",
        "http.request.method",
        "http.request.timestamp.msec",
        "http.request.timestamp.sec",
        "http.request.uri",
        "http.request.uri.args",
        "http.request.uri.args.names",
        "http.request.uri.args.values",
        "http.request.uri.path",
        "http.request.uri.path.extension",
        "http.request.uri.query",
        "http.request.version",
        "http.response.code",
        "http.response.content_type.media_type",
        "http.response.headers",
        "http.response.headers.names",
        "http.response.headers.values",
        "http.user_agent",
        "http.x_forwarded_for",
        "icmp",
        "icmp.code",
        "icmp.type",
        "ip",
        "ip.dst",
        "ip.dst.country",
        "ip.hdr_len",
        "ip.len",
        "ip.opt.type",
        "ip.proto",
        "ip.src",
        "ip.src.asnum",
        "ip.src.city",
        "ip.src.continent",
        "ip.src.country",
        "ip.src.is_in_european_union",
        "ip.src.lat",
        "ip.src.lon",
        "ip.src.metro_code",
        "ip.src.postal_code",
        "ip.src.region",
        "ip.src.region_code",
        "ip.src.subdivision_1_iso_code",
        "ip.src.subdivision_2_iso_code",
        "ip.src.timezone.name",
        "ip.ttl",
        "raw.http.request.full_uri",
        "raw.http.request.uri",
        "raw.http.request.uri.args",
        "raw.http.request.uri.args.names",
        "raw.http.request.uri.args.values",
        "raw.http.request.uri.path",
        "raw.http.request.uri.path.extension",
        "raw.http.request.uri.query",
        "sip",
        "ssl",
        "tcp",
        "tcp.dstport",
        "tcp.flags",
        "tcp.flags.ack",
        "tcp.flags.cwr",
        "tcp.flags.ecn",
        "tcp.flags.fin",
        "tcp.flags.push",
        "tcp.flags.reset",
        "tcp.flags.syn",
        "tcp.flags.urg",
        "tcp.srcport",
        "udp",
        "udp.dstport",
        "udp.srcport",
    ];

    private array $comparisonOperators = [
        'eq' => "equal",
        'ne' => "notEqual",
        'lt' => "lessThan",
        'le' => "lessThanOrEqual",
        'gt' => "greaterThan",
        'ge' => "greaterThanOrEqual",
        'contains' => "contains",
        'matches' => "matches",
        'in' => "in",
    ];

    private array $logicalOperators = [
        'not',
        'and',
        'or'
    ];

    /**
     * array of expressions
     * @var array[]
     */
    private array $expressions = [];

    /**
     * Group expressions.
     *
     * @link https://developers.cloudflare.com/ruleset-engine/rules-language/operators/
     *
     * @param \Closure $callback
     * @return \Cloudflare\ExpressionBuilder
     */
    public function group(Closure $closure): self
    {

        $builder = new static();

        $closure($builder);

        $this->expressions[] = "({$builder->build()})";

        return $this;
    }

    /**
     * Add expression
     *
     * @link https://developers.cloudflare.com/ruleset-engine/rules-language/expressions/
     *
     * @param string $field The Cloudflare Rules field.
     * @param string $operator The Cloudflare Rules operator.
     * @param mixed $value
     * @return \Cloudflare\ExpressionBuilder
     */
    public function addExpression(string $field = null, string $operator = null, mixed $value = null): self
    {
        if ($operator && $value) {

            $this->expressions[] = (is_null($field) ? "" : "{$field} ")."{$operator} {$this->formatValue($value)}";

        } else {

            $this->expressions[] = $field;

        }

        return $this;
    }

    /**
     * Add function
     *
     * @link https://developers.cloudflare.com/ruleset-engine/rules-language/functions/
     *
     * @param string $functionName The Cloudflare Rules function.
     * @param string $field The Cloudflare Rules field.
     * @param string $operator The Cloudflare Rules operator.
     * @param mixed $value
     *
     * @throws \Cloudflare\Exceptions\InvalidArgumentException
     *
     * @return \Cloudflare\ExpressionBuilder
     */
    public function addFunction(string $functionName, string $field, string $operator = null, mixed $value = null): self
    {
        if (! $this->isFieldName($field)) {

            throw new InvalidArgumentException(sprintf('Undefined field name: "%s"', $field));
        }

        if ($operator && $value) {

            $this->expressions[] = "{$functionName}({$field}) {$operator} {$this->formatValue($value)}";

        } else {

            $this->expressions[] = "{$functionName}({$field})";
        }

        return $this;
    }

    /**
     * Add field
     * @param string $field
     * @return \Cloudflare\ExpressionBuilder
     */
    public function field(string $field): self
    {

        if(!$this->isFieldName($field)) {
            throw new InvalidArgumentException(sprintf('Undefined field name: "%s"', $field));
        }

        return $this->addExpression($field);
    }

    /**
     * The wildcard operator performs a case-insensitive match between a field value and a literal string containing zero or more * metacharacters. The strict wildcard operator performs a similar match, but is case sensitive.
     * @param string $value
     * @param bool $strict
     * @return \Cloudflare\ExpressionBuilder
     */
    public function wildcard(string $value, bool $strict): self
    {
        return $this->addExpression(
            operator: ($strict ? "strict " : "")."wildcard",
            value: $value
        );
    }

    /**
     * Build expression
     * @return string
     */
    public function build(): string
    {
        $result = implode(" ", $this->expressions);

        if (str_starts_with($result, "(") && str_ends_with($result, ")") && substr_count($result, "(") === 1) {
            $result = substr($result, 1, -1);
        }

        return $result;
    }

    /**
     * Format value
     * @param mixed $value
     * @return string
     */
    private function formatValue(mixed $value): string
    {
        if (is_string($value)) {

            if ($this->isFieldName($value) || filter_var($value, FILTER_VALIDATE_IP)) {
                return $value;
            }

            return '"'.trim($value).'"';

        } elseif(is_array($value)) {

            return "{".implode(" ", array_map(fn (string $v) => $this->formatValue($v), $value))."}";
        }

        return (string)$value;
    }

    /**
     * Checks if the value is a field
     * @param string $value
     * @return bool
     */
    private function isFieldName(string $value): bool
    {
        return in_array($value, $this->fields);
    }

    public function __call($name, $arguments)
    {
        if (array_key_exists($name, $this->comparisonOperators) || in_array($name, $this->comparisonOperators)) {

            return $this->addExpression(operator: $name, value: $arguments[0]);

        } elseif(in_array($name, $this->logicalOperators)) {

            return $this->addExpression($name);

        } else {

            throw new BadMethodCallException(sprintf('Undefined method called: "%s"', $name));

        }
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->build();
    }
}
