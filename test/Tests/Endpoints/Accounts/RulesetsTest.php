<?php

namespace Cloudflare\Tests\Endpoints\Accounts;

use Cloudflare\Configurations\Ruleset;
use Cloudflare\Configurations\Rules\BlockRule;
use Cloudflare\Tests\Concerns\InteractsWithMockClient;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class RulesetsTest extends TestCase
{
    use InteractsWithMockClient;

    #[Test]
    public function shouldGet()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => [['id' => 'ruleset_id']]])),
        ]);

        $response = $client->accounts()->rulesets()->get('account_id');

        $this->assertTrue($response->successful());
        $this->assertSame('GET', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/accounts/account_id/rulesets', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldCreateWithArray()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => ['id' => 'ruleset_id']])),
        ]);

        $response = $client->accounts()->rulesets()->create('account_id', [
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
    public function shouldCreateWithEmptyRulesArray()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => ['id' => 'ruleset_id']])),
        ]);

        $response = $client->accounts()->rulesets()->create('account_id', [
            'name' => 'my ruleset',
            'kind' => 'root',
            'phase' => 'http_request_firewall_custom',
            'rules' => [],
        ]);

        $this->assertTrue($response->successful());
        $this->assertSame('POST', $this->lastRequest()->getMethod());
    }

    #[Test]
    public function shouldCreateWithoutRulesKey()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => ['id' => 'ruleset_id']])),
        ]);

        $response = $client->accounts()->rulesets()->create('account_id', [
            'name' => 'my ruleset',
            'kind' => 'root',
            'phase' => 'http_request_firewall_custom',
        ]);

        $this->assertTrue($response->successful());
        $this->assertSame('POST', $this->lastRequest()->getMethod());
    }

    #[Test]
    public function shouldCreateWithRulesetObject()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => ['id' => 'ruleset_id']])),
        ]);

        $ruleset = (new Ruleset('my ruleset'))->addRule((new BlockRule(['error' => 'blocked']))->setExpression('true'));

        $response = $client->accounts()->rulesets()->create('account_id', $ruleset);

        $this->assertTrue($response->successful());
        $this->assertSame('POST', $this->lastRequest()->getMethod());
    }

    #[Test]
    public function shouldGetDetails()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => ['id' => 'ruleset_id']])),
        ]);

        $response = $client->accounts()->rulesets()->details('account_id', 'ruleset_id');

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

        $response = $client->accounts()->rulesets()->delete('account_id', 'ruleset_id');

        $this->assertTrue($response->successful());
        $this->assertSame('DELETE', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/accounts/account_id/rulesets/ruleset_id', $this->lastRequest()->getUri()->getPath());
    }
}
