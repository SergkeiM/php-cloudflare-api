<?php

namespace Cloudflare\Tests\Endpoints\Firewall;

use Cloudflare\Exceptions\MissingArgumentException;
use Cloudflare\Tests\Concerns\InteractsWithMockClient;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\Test;

class UaRulesTest extends TestCase
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

        $response = $client->firewall()->uaRules()->list('zone_id', ['paused' => 'false', 'per_page' => 20]);

        $this->assertTrue($response->successful());
        $this->assertSame('rule_id', $response->json('result.0.id'));

        $this->assertSame('GET', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/zones/zone_id/firewall/ua_rules', $this->lastRequest()->getUri()->getPath());
        $this->assertSame('paused=false&per_page=20', $this->lastRequest()->getUri()->getQuery());
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
            'configuration' => ['target' => 'ua', 'value' => 'BadCrawler/1.0'],
            'description' => 'Block a misbehaving crawler',
        ];

        $response = $client->firewall()->uaRules()->create('zone_id', $values);

        $this->assertTrue($response->successful());

        $this->assertSame('POST', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/zones/zone_id/firewall/ua_rules', $this->lastRequest()->getUri()->getPath());
        $this->assertSame($values, json_decode((string) $this->lastRequest()->getBody(), true));
    }

    #[Test]
    public function shouldThrowWhenCreatingWithoutModeOrConfiguration()
    {
        $client = $this->mockClient([]);

        $this->expectException(MissingArgumentException::class);

        $client->firewall()->uaRules()->create('zone_id', ['description' => 'no mode here']);
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

        $response = $client->firewall()->uaRules()->get('zone_id', 'rule_id');

        $this->assertTrue($response->successful());
        $this->assertSame('challenge', $response->json('result.mode'));

        $this->assertSame('GET', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/zones/zone_id/firewall/ua_rules/rule_id', $this->lastRequest()->getUri()->getPath());
    }

    /**
     * Cloudflare expects the rule's own id in the body too, so it is filled in
     * from the path rather than being left to the caller to repeat.
     */
    #[Test]
    public function shouldUpdateRuleAndFillInTheIdFromThePath()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode([
                'success' => true,
                'result' => ['id' => 'rule_id'],
            ])),
        ]);

        $response = $client->firewall()->uaRules()->update('zone_id', 'rule_id', [
            'mode' => 'managed_challenge',
            'configuration' => ['target' => 'ua', 'value' => 'BadCrawler/2.0'],
        ]);

        $this->assertTrue($response->successful());

        $this->assertSame('PUT', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/zones/zone_id/firewall/ua_rules/rule_id', $this->lastRequest()->getUri()->getPath());
        $this->assertSame([
            'id' => 'rule_id',
            'mode' => 'managed_challenge',
            'configuration' => ['target' => 'ua', 'value' => 'BadCrawler/2.0'],
        ], json_decode((string) $this->lastRequest()->getBody(), true));
    }

    #[Test]
    public function shouldThrowWhenUpdatingWithoutModeOrConfiguration()
    {
        $client = $this->mockClient([]);

        $this->expectException(MissingArgumentException::class);

        $client->firewall()->uaRules()->update('zone_id', 'rule_id', ['paused' => true]);
    }

    #[Test]
    public function shouldDeleteRule()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => ['id' => 'rule_id']])),
        ]);

        $response = $client->firewall()->uaRules()->delete('zone_id', 'rule_id');

        $this->assertTrue($response->successful());

        $this->assertSame('DELETE', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/zones/zone_id/firewall/ua_rules/rule_id', $this->lastRequest()->getUri()->getPath());
    }
}
