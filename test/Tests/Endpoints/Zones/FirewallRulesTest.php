<?php

namespace Cloudflare\Tests\Endpoints\Zones;

use Cloudflare\Tests\Concerns\InteractsWithMockClient;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\Test;

class FirewallRulesTest extends TestCase
{
    use InteractsWithMockClient;

    #[Test]
    public function shouldListFirewallRules()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode([
                'success' => true,
                'result' => [
                    ['id' => 'rule_id'],
                ],
            ])),
        ]);

        $response = $client->zones()->firewallRules()->list('zone_id');

        $this->assertTrue($response->successful());
        $this->assertSame('rule_id', $response->json('result.0.id'));

        $this->assertSame('GET', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/zones/zone_id/firewall/rules', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldGetFirewallRuleDetails()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode([
                'success' => true,
                'result' => [
                    'id' => 'rule_id',
                ],
            ])),
        ]);

        $response = $client->zones()->firewallRules()->details('zone_id', 'rule_id');

        $this->assertTrue($response->successful());
        $this->assertSame('rule_id', $response->json('result.id'));

        $this->assertSame('GET', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/zones/zone_id/firewall/rules/rule_id', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldCreateFirewallRules()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode([
                'success' => true,
                'result' => [
                    ['id' => 'rule_id'],
                ],
            ])),
        ]);

        $response = $client->zones()->firewallRules()->create('zone_id', [
            [
                'action' => 'block',
                'filter' => ['id' => 'filter_id'],
            ],
        ]);

        $this->assertTrue($response->successful());
        $this->assertSame('rule_id', $response->json('result.0.id'));

        $this->assertSame('POST', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/zones/zone_id/firewall/rules', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldUpdateFirewallRule()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode([
                'success' => true,
                'result' => [
                    'id' => 'rule_id',
                    'action' => 'challenge',
                ],
            ])),
        ]);

        $response = $client->zones()->firewallRules()->update('zone_id', 'rule_id', [
            'action' => 'challenge',
            'filter' => ['id' => 'filter_id'],
        ]);

        $this->assertTrue($response->successful());
        $this->assertSame('challenge', $response->json('result.action'));

        $this->assertSame('PUT', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/zones/zone_id/firewall/rules/rule_id', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldUpdateFirewallRulePriority()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode([
                'success' => true,
                'result' => [
                    'id' => 'rule_id',
                    'priority' => 5,
                ],
            ])),
        ]);

        $response = $client->zones()->firewallRules()->updatePriority('zone_id', 'rule_id', 5);

        $this->assertTrue($response->successful());
        $this->assertSame(5, $response->json('result.priority'));

        $this->assertSame('PATCH', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/zones/zone_id/firewall/rules/rule_id', $this->lastRequest()->getUri()->getPath());
        $this->assertSame(['priority' => 5], json_decode((string) $this->lastRequest()->getBody(), true));
    }

    #[Test]
    public function shouldDeleteFirewallRule()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode([
                'success' => true,
                'result' => [
                    'id' => 'rule_id',
                ],
            ])),
        ]);

        $response = $client->zones()->firewallRules()->delete('zone_id', 'rule_id');

        $this->assertTrue($response->successful());

        $this->assertSame('DELETE', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/zones/zone_id/firewall/rules/rule_id', $this->lastRequest()->getUri()->getPath());
    }
}
