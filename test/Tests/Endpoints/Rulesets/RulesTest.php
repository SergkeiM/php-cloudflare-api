<?php

namespace Cloudflare\Tests\Endpoints\Rulesets;

use Cloudflare\Configurations\Rules\BlockRule;
use Cloudflare\Tests\Concerns\InteractsWithMockClient;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class RulesTest extends TestCase
{
    use InteractsWithMockClient;

    #[Test]
    public function shouldCreateWithArray()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => ['id' => 'rule_id']])),
        ]);

        $response = $client->rulesets()->rules()->create(null, 'zone_id', 'ruleset_id', [
            'action' => 'block',
            'expression' => 'true',
        ]);

        $this->assertTrue($response->successful());
        $this->assertSame('POST', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/zones/zone_id/rulesets/ruleset_id/rules', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldCreateWithRuleObject()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => ['id' => 'rule_id']])),
        ]);

        $rule = (new BlockRule('{"error": "blocked"}'))->enable()->setExpression('true');

        $response = $client->rulesets()->rules()->create('account_id', null, 'ruleset_id', $rule);

        $this->assertTrue($response->successful());
        $this->assertSame('POST', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/accounts/account_id/rulesets/ruleset_id/rules', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldEditWithArray()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => ['id' => 'ruleset_id']])),
        ]);

        $values = ['action' => 'block', 'expression' => 'false'];

        $response = $client->rulesets()->rules()->edit(null, 'zone_id', 'ruleset_id', 'rule_id', $values);

        $this->assertTrue($response->successful());
        $this->assertSame('PATCH', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/zones/zone_id/rulesets/ruleset_id/rules/rule_id', $this->lastRequest()->getUri()->getPath());
        $this->assertSame($values, json_decode((string) $this->lastRequest()->getBody(), true));
    }

    #[Test]
    public function shouldEditWithRuleObject()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => ['id' => 'ruleset_id']])),
        ]);

        $rule = (new BlockRule('{"error": "blocked"}'))->disable()->setExpression('true');

        $response = $client->rulesets()->rules()->edit('account_id', null, 'ruleset_id', 'rule_id', $rule);

        $this->assertTrue($response->successful());
        $this->assertSame('PATCH', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/accounts/account_id/rulesets/ruleset_id/rules/rule_id', $this->lastRequest()->getUri()->getPath());
        $this->assertSame($rule->toArray(), json_decode((string) $this->lastRequest()->getBody(), true));
    }

    #[Test]
    public function shouldDelete()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => ['id' => 'ruleset_id']])),
        ]);

        $response = $client->rulesets()->rules()->delete(null, 'zone_id', 'ruleset_id', 'rule_id');

        $this->assertTrue($response->successful());
        $this->assertSame('DELETE', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/zones/zone_id/rulesets/ruleset_id/rules/rule_id', $this->lastRequest()->getUri()->getPath());
    }
}
