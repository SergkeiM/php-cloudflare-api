<?php

namespace Cloudflare\Tests\Endpoints;

use Cloudflare\Configurations\Ruleset;
use Cloudflare\Configurations\Rules\BlockRule;
use Cloudflare\Exceptions\InvalidArgumentException;
use Cloudflare\Tests\Concerns\InteractsWithMockClient;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class RulesetsTest extends TestCase
{
    use InteractsWithMockClient;

    #[Test]
    public function shouldListForAccount()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => [['id' => 'ruleset_id']]])),
        ]);

        $response = $client->rulesets()->list(accountId: 'account_id');

        $this->assertTrue($response->successful());
        $this->assertSame('GET', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/accounts/account_id/rulesets', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldListForZone()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => [['id' => 'ruleset_id']]])),
        ]);

        $response = $client->rulesets()->list(zoneId: 'zone_id');

        $this->assertTrue($response->successful());
        $this->assertSame('GET', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/zones/zone_id/rulesets', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldThrowWhenNeitherScopeProvided()
    {
        $client = $this->mockClient([]);

        $this->expectException(InvalidArgumentException::class);

        $client->rulesets()->list();
    }

    #[Test]
    public function shouldCreateWithArray()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => ['id' => 'ruleset_id']])),
        ]);

        $response = $client->rulesets()->create('account_id', null, [
            'name' => 'my ruleset',
            'kind' => 'root',
            'phase' => 'http_request_firewall_custom',
            'rules' => [['action' => 'block', 'expression' => 'true']],
        ]);

        $this->assertTrue($response->successful());
        $this->assertSame('POST', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/accounts/account_id/rulesets', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldCreateWithRulesetObject()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => ['id' => 'ruleset_id']])),
        ]);

        $ruleset = (new Ruleset('my ruleset'))->addRule((new BlockRule(['error' => 'blocked']))->setExpression('true'));

        $response = $client->rulesets()->create(null, 'zone_id', $ruleset);

        $this->assertTrue($response->successful());
        $this->assertSame('POST', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/zones/zone_id/rulesets', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldGetDetails()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => ['id' => 'ruleset_id']])),
        ]);

        $response = $client->rulesets()->get('account_id', null, 'ruleset_id');

        $this->assertTrue($response->successful());
        $this->assertSame('GET', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/accounts/account_id/rulesets/ruleset_id', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldDelete()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => null])),
        ]);

        $response = $client->rulesets()->delete(null, 'zone_id', 'ruleset_id');

        $this->assertTrue($response->successful());
        $this->assertSame('DELETE', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/zones/zone_id/rulesets/ruleset_id', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldUpdateWithArray()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => ['id' => 'ruleset_id']])),
        ]);

        $values = ['rules' => [['action' => 'block', 'expression' => 'true']]];

        $response = $client->rulesets()->update(null, 'zone_id', 'ruleset_id', $values);

        $this->assertTrue($response->successful());
        $this->assertSame('PUT', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/zones/zone_id/rulesets/ruleset_id', $this->lastRequest()->getUri()->getPath());
        $this->assertSame($values, json_decode((string) $this->lastRequest()->getBody(), true));
    }

    #[Test]
    public function shouldUpdateWithRulesetObject()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => ['id' => 'ruleset_id']])),
        ]);

        $ruleset = (new Ruleset('my ruleset'))->addRule((new BlockRule(['error' => 'blocked']))->setExpression('true'));

        $response = $client->rulesets()->update('account_id', null, 'ruleset_id', $ruleset);

        $this->assertTrue($response->successful());
        $this->assertSame('PUT', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/accounts/account_id/rulesets/ruleset_id', $this->lastRequest()->getUri()->getPath());
        $this->assertSame($ruleset->toArray(), json_decode((string) $this->lastRequest()->getBody(), true));
    }
}
