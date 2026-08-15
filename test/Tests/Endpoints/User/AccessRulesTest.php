<?php

namespace Cloudflare\Tests\Endpoints\User;

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

        $response = $client->user()->accessRules()->list(['mode' => 'block', 'per_page' => 20]);

        $this->assertTrue($response->successful());
        $this->assertSame('rule_id', $response->json('result.0.id'));

        $this->assertSame('GET', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/user/firewall/access_rules/rules', $this->lastRequest()->getUri()->getPath());
        $this->assertSame('mode=block&per_page=20', $this->lastRequest()->getUri()->getQuery());
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

        $response = $client->user()->accessRules()->create($values);

        $this->assertTrue($response->successful());

        $this->assertSame('POST', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/user/firewall/access_rules/rules', $this->lastRequest()->getUri()->getPath());
        $this->assertSame($values, json_decode((string) $this->lastRequest()->getBody(), true));
    }

    #[Test]
    public function shouldThrowWhenCreatingWithoutModeOrConfiguration()
    {
        $client = $this->mockClient([]);

        $this->expectException(MissingArgumentException::class);

        $client->user()->accessRules()->create(['notes' => 'no mode here']);
    }

    #[Test]
    public function shouldGetRule()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode([
                'success' => true,
                'result' => ['id' => 'rule_id', 'mode' => 'challenge'],
            ])),
        ]);

        $response = $client->user()->accessRules()->get('rule_id');

        $this->assertTrue($response->successful());
        $this->assertSame('challenge', $response->json('result.mode'));

        $this->assertSame('GET', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/user/firewall/access_rules/rules/rule_id', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldEditRule()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode([
                'success' => true,
                'result' => ['id' => 'rule_id', 'mode' => 'whitelist'],
            ])),
        ]);

        $response = $client->user()->accessRules()->edit('rule_id', ['mode' => 'whitelist']);

        $this->assertTrue($response->successful());

        $this->assertSame('PATCH', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/user/firewall/access_rules/rules/rule_id', $this->lastRequest()->getUri()->getPath());
        $this->assertSame(['mode' => 'whitelist'], json_decode((string) $this->lastRequest()->getBody(), true));
    }

    #[Test]
    public function shouldDeleteRule()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => null])),
        ]);

        $response = $client->user()->accessRules()->delete('rule_id');

        $this->assertTrue($response->successful());

        $this->assertSame('DELETE', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/user/firewall/access_rules/rules/rule_id', $this->lastRequest()->getUri()->getPath());
    }
}
