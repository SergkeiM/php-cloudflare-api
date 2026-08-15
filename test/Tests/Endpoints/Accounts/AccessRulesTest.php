<?php

namespace Cloudflare\Tests\Endpoints\Accounts;

use Cloudflare\Exceptions\MissingArgumentException;
use Cloudflare\Tests\Concerns\InteractsWithMockClient;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\Test;

class AccessRulesTest extends TestCase
{
    use InteractsWithMockClient;

    #[Test]
    public function shouldListRules()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode([
                'success' => true,
                'result' => [
                    ['id' => 'rule_id', 'mode' => 'block'],
                ],
            ])),
        ]);

        $response = $client->accounts()->accessRules()->list('account_id', ['mode' => 'block']);

        $this->assertTrue($response->successful());
        $this->assertSame('rule_id', $response->json('result.0.id'));

        $this->assertSame('GET', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/accounts/account_id/firewall/access_rules/rules', $this->lastRequest()->getUri()->getPath());
        $this->assertSame('mode=block', $this->lastRequest()->getUri()->getQuery());
    }

    #[Test]
    public function shouldCreateRule()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode([
                'success' => true,
                'result' => ['id' => 'rule_id'],
            ])),
        ]);

        $values = [
            'mode' => 'block',
            'configuration' => ['target' => 'ip', 'value' => '198.51.100.4'],
        ];

        $response = $client->accounts()->accessRules()->create('account_id', $values);

        $this->assertTrue($response->successful());

        $this->assertSame('POST', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/accounts/account_id/firewall/access_rules/rules', $this->lastRequest()->getUri()->getPath());
        $this->assertSame($values, json_decode((string) $this->lastRequest()->getBody(), true));
    }

    #[Test]
    public function shouldThrowWhenCreatingWithoutModeOrConfiguration()
    {
        $client = $this->mockClient([]);

        $this->expectException(MissingArgumentException::class);

        $client->accounts()->accessRules()->create('account_id', ['notes' => 'no mode here']);
    }

    #[Test]
    public function shouldGetRule()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode([
                'success' => true,
                'result' => ['id' => 'rule_id', 'mode' => 'whitelist'],
            ])),
        ]);

        $response = $client->accounts()->accessRules()->get('account_id', 'rule_id');

        $this->assertTrue($response->successful());
        $this->assertSame('whitelist', $response->json('result.mode'));

        $this->assertSame('GET', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/accounts/account_id/firewall/access_rules/rules/rule_id', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldEditRule()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode([
                'success' => true,
                'result' => ['id' => 'rule_id'],
            ])),
        ]);

        $response = $client->accounts()->accessRules()->edit('account_id', 'rule_id', ['notes' => 'Updated']);

        $this->assertTrue($response->successful());

        $this->assertSame('PATCH', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/accounts/account_id/firewall/access_rules/rules/rule_id', $this->lastRequest()->getUri()->getPath());
        $this->assertSame(['notes' => 'Updated'], json_decode((string) $this->lastRequest()->getBody(), true));
    }

    #[Test]
    public function shouldDeleteRule()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => null])),
        ]);

        $response = $client->accounts()->accessRules()->delete('account_id', 'rule_id');

        $this->assertTrue($response->successful());

        $this->assertSame('DELETE', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/accounts/account_id/firewall/access_rules/rules/rule_id', $this->lastRequest()->getUri()->getPath());
    }
}
