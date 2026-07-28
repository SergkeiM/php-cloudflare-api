<?php

namespace Cloudflare\Tests\Endpoints;

use Cloudflare\Tests\Concerns\InteractsWithMockClient;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\Test;

class FirewallRulesTest extends TestCase
{
    use InteractsWithMockClient;

    #[Test]
    public function shouldList()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => [['id' => 'rule_id']]])),
        ]);

        $response = $client->firewallRules()->list('zone_id');

        $this->assertTrue($response->successful());
        $this->assertSame('GET', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/zones/zone_id/firewall/rules', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldGet()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => ['id' => 'rule_id']])),
        ]);

        $response = $client->firewallRules()->get('zone_id', 'rule_id');

        $this->assertTrue($response->successful());
        $this->assertSame('GET', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/zones/zone_id/firewall/rules/rule_id', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldCreate()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => [['id' => 'rule_id']]])),
        ]);

        $response = $client->firewallRules()->create('zone_id', [
            ['action' => 'block', 'filter' => ['expression' => 'ip.src eq 127.0.0.1']],
        ]);

        $this->assertTrue($response->successful());
        $this->assertSame('POST', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/zones/zone_id/firewall/rules', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldUpdate()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => ['id' => 'rule_id']])),
        ]);

        $response = $client->firewallRules()->update('zone_id', 'rule_id', [
            'action' => 'block',
            'filter' => ['id' => 'filter_id'],
        ]);

        $this->assertTrue($response->successful());
        $this->assertSame('PUT', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/zones/zone_id/firewall/rules/rule_id', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldUpdatePriority()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => ['id' => 'rule_id', 'priority' => 5]])),
        ]);

        $response = $client->firewallRules()->updatePriority('zone_id', 'rule_id', 5);

        $this->assertTrue($response->successful());
        $this->assertSame('PATCH', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/zones/zone_id/firewall/rules/rule_id', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldDelete()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => ['id' => 'rule_id']])),
        ]);

        $response = $client->firewallRules()->delete('zone_id', 'rule_id');

        $this->assertTrue($response->successful());
        $this->assertSame('DELETE', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/zones/zone_id/firewall/rules/rule_id', $this->lastRequest()->getUri()->getPath());
    }
}
