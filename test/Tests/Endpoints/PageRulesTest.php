<?php

namespace Cloudflare\Tests\Endpoints;

use Cloudflare\Tests\Concerns\InteractsWithMockClient;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\Test;

class PageRulesTest extends TestCase
{
    use InteractsWithMockClient;

    #[Test]
    public function shouldGetSettings()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => []])),
        ]);

        $response = $client->pageRules()->settings('zone_id');

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

        $response = $client->pageRules()->list('zone_id');

        $this->assertTrue($response->successful());
        $this->assertSame('GET', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/zones/zone_id/pagerules', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldCreate()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => ['id' => 'page_rule_id']])),
        ]);

        $response = $client->pageRules()->create('zone_id', [
            'targets' => [['target' => 'url', 'constraint' => ['operator' => 'matches', 'value' => '*example.com/*']]],
            'actions' => [['id' => 'always_use_https']],
        ]);

        $this->assertTrue($response->successful());
        $this->assertSame('POST', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/zones/zone_id/pagerules', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldGetDetails()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => ['id' => 'page_rule_id']])),
        ]);

        $response = $client->pageRules()->get('zone_id', 'page_rule_id');

        $this->assertTrue($response->successful());
        $this->assertSame('GET', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/zones/zone_id/pagerules/page_rule_id', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldEdit()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => ['id' => 'page_rule_id']])),
        ]);

        $response = $client->pageRules()->edit('zone_id', 'page_rule_id', [
            'targets' => [['target' => 'url', 'constraint' => ['operator' => 'matches', 'value' => '*example.com/*']]],
            'actions' => [['id' => 'always_use_https']],
        ]);

        $this->assertTrue($response->successful());
        $this->assertSame('PATCH', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/zones/zone_id/pagerules/page_rule_id', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldUpdate()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => ['id' => 'page_rule_id']])),
        ]);

        $response = $client->pageRules()->update('zone_id', 'page_rule_id', [
            'targets' => [['target' => 'url', 'constraint' => ['operator' => 'matches', 'value' => '*example.com/*']]],
            'actions' => [['id' => 'always_use_https']],
        ]);

        $this->assertTrue($response->successful());
        $this->assertSame('PUT', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/zones/zone_id/pagerules/page_rule_id', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldDelete()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => ['id' => 'page_rule_id']])),
        ]);

        $response = $client->pageRules()->delete('zone_id', 'page_rule_id');

        $this->assertTrue($response->successful());
        $this->assertSame('DELETE', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/zones/zone_id/pagerules/page_rule_id', $this->lastRequest()->getUri()->getPath());
    }
}
