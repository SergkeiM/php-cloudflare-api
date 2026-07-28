<?php

namespace Cloudflare\Tests\Endpoints\Zones;

use Cloudflare\Configurations\Zones\PageRule;
use Cloudflare\Tests\Concerns\InteractsWithMockClient;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class PageRulesTest extends TestCase
{
    use InteractsWithMockClient;

    #[Test]
    public function shouldGetSettings()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => []])),
        ]);

        $response = $client->zones()->pageRules()->settings('zone_id');

        $this->assertTrue($response->successful());
        $this->assertSame('GET', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/zones/zone_id/pagerules/settings', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldList()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => [['id' => 'page_rule_id']]])),
        ]);

        $response = $client->zones()->pageRules()->list('zone_id');

        $this->assertTrue($response->successful());
        $this->assertSame('GET', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/zones/zone_id/pagerules', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldCreateWithArray()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => ['id' => 'page_rule_id']])),
        ]);

        $response = $client->zones()->pageRules()->create('zone_id', [
            'targets' => [['target' => 'url', 'constraint' => ['operator' => 'matches', 'value' => 'example.com/*']]],
            'actions' => [['id' => 'ssl', 'value' => 'flexible']],
        ]);

        $this->assertTrue($response->successful());
        $this->assertSame('POST', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/zones/zone_id/pagerules', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldCreateWithPageRuleObject()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => ['id' => 'page_rule_id']])),
        ]);

        $pageRule = (new PageRule('example.com/*'))->enable()->ssl('flexible');

        $response = $client->zones()->pageRules()->create('zone_id', $pageRule);

        $this->assertTrue($response->successful());
        $this->assertSame('POST', $this->lastRequest()->getMethod());
    }

    #[Test]
    public function shouldGetDetails()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => ['id' => 'page_rule_id']])),
        ]);

        $response = $client->zones()->pageRules()->details('zone_id', 'page_rule_id');

        $this->assertTrue($response->successful());
        $this->assertSame('GET', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/zones/zone_id/pagerules/page_rule_id', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldUpdateWithArray()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => ['id' => 'page_rule_id']])),
        ]);

        $response = $client->zones()->pageRules()->update('zone_id', 'page_rule_id', [
            'targets' => [['target' => 'url', 'constraint' => ['operator' => 'matches', 'value' => 'example.com/*']]],
            'actions' => [['id' => 'ssl', 'value' => 'flexible']],
        ]);

        $this->assertTrue($response->successful());
        $this->assertSame('PATCH', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/zones/zone_id/pagerules/page_rule_id', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldUpdateWithPageRuleObject()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => ['id' => 'page_rule_id']])),
        ]);

        $pageRule = (new PageRule('example.com/*'))->disable();

        $response = $client->zones()->pageRules()->update('zone_id', 'page_rule_id', $pageRule);

        $this->assertTrue($response->successful());
        $this->assertSame('PATCH', $this->lastRequest()->getMethod());
    }

    #[Test]
    public function shouldOverwriteWithArray()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => ['id' => 'page_rule_id']])),
        ]);

        $response = $client->zones()->pageRules()->overwrite('zone_id', 'page_rule_id', [
            'targets' => [['target' => 'url', 'constraint' => ['operator' => 'matches', 'value' => 'example.com/*']]],
            'actions' => [['id' => 'ssl', 'value' => 'flexible']],
        ]);

        $this->assertTrue($response->successful());
        $this->assertSame('PUT', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/zones/zone_id/pagerules/page_rule_id', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldOverwriteWithPageRuleObject()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => ['id' => 'page_rule_id']])),
        ]);

        $pageRule = new PageRule('example.com/*');

        $response = $client->zones()->pageRules()->overwrite('zone_id', 'page_rule_id', $pageRule);

        $this->assertTrue($response->successful());
        $this->assertSame('PUT', $this->lastRequest()->getMethod());
    }

    #[Test]
    public function shouldDelete()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => ['id' => 'page_rule_id']])),
        ]);

        $response = $client->zones()->pageRules()->delete('zone_id', 'page_rule_id');

        $this->assertTrue($response->successful());
        $this->assertSame('DELETE', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/zones/zone_id/pagerules/page_rule_id', $this->lastRequest()->getUri()->getPath());
    }
}
