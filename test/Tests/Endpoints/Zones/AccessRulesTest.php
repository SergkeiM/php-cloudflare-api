<?php

namespace Cloudflare\Tests\Endpoints\Zones;

use Cloudflare\Tests\Concerns\InteractsWithMockClient;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\Test;

class AccessRulesTest extends TestCase
{
    use InteractsWithMockClient;

    #[Test]
    public function shouldListAccessRules()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode([
                'success' => true,
                'result' => [
                    ['id' => 'rule_id'],
                ],
            ])),
        ]);

        $response = $client->zones()->accessRules()->list('zone_id');

        $this->assertTrue($response->successful());
        $this->assertSame('rule_id', $response->json('result.0.id'));

        $this->assertSame('GET', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/zones/zone_id/firewall/access_rules/rules', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldCreateAccessRule()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode([
                'success' => true,
                'result' => [
                    'id' => 'rule_id',
                ],
            ])),
        ]);

        $response = $client->zones()->accessRules()->create('zone_id', [
            'mode' => 'block',
            'configuration' => [
                'target' => 'ip',
                'value' => '127.0.0.1',
            ],
        ]);

        $this->assertTrue($response->successful());
        $this->assertSame('rule_id', $response->json('result.id'));

        $this->assertSame('POST', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/zones/zone_id/firewall/access_rules/rules', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldUpdateAccessRule()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode([
                'success' => true,
                'result' => [
                    'id' => 'rule_id',
                    'mode' => 'challenge',
                ],
            ])),
        ]);

        $response = $client->zones()->accessRules()->update('zone_id', 'rule_id', [
            'mode' => 'challenge',
        ]);

        $this->assertTrue($response->successful());
        $this->assertSame('challenge', $response->json('result.mode'));

        $this->assertSame('PATCH', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/zones/zone_id/firewall/access_rules/rules/rule_id', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldDeleteAccessRule()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode([
                'success' => true,
                'result' => [
                    'id' => 'rule_id',
                ],
            ])),
        ]);

        $response = $client->zones()->accessRules()->delete('zone_id', 'rule_id');

        $this->assertTrue($response->successful());

        $this->assertSame('DELETE', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/zones/zone_id/firewall/access_rules/rules/rule_id', $this->lastRequest()->getUri()->getPath());
    }
}
