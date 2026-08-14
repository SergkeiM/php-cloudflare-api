<?php

namespace Cloudflare\Tests\Endpoints;

use Cloudflare\Configurations\Zones\PageRule;
use Cloudflare\Exceptions\MissingArgumentException;
use Cloudflare\Tests\Concerns\InteractsWithMockClient;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\TestWith;

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
    public function shouldCreateWithPageRuleObject()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => ['id' => 'page_rule_id']])),
        ]);

        $config = (new PageRule('*example.com/*'))->alwaysUseHTTPS(true)->enable();

        $response = $client->pageRules()->create('zone_id', $config);

        $this->assertTrue($response->successful());
        $this->assertSame('POST', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/zones/zone_id/pagerules', $this->lastRequest()->getUri()->getPath());
        $this->assertSame($config->toArray(), json_decode((string) $this->lastRequest()->getBody(), true));
    }

    #[Test]
    public function shouldEditWithPageRuleObject()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => ['id' => 'page_rule_id']])),
        ]);

        $config = (new PageRule('*example.com/*'))->cacheLevel('cache_everything')->setPriority(2);

        $response = $client->pageRules()->edit('zone_id', 'page_rule_id', $config);

        $this->assertTrue($response->successful());
        $this->assertSame('PATCH', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/zones/zone_id/pagerules/page_rule_id', $this->lastRequest()->getUri()->getPath());
        $this->assertSame($config->toArray(), json_decode((string) $this->lastRequest()->getBody(), true));
    }

    #[Test]
    public function shouldUpdateWithPageRuleObject()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => ['id' => 'page_rule_id']])),
        ]);

        $config = (new PageRule('*example.com/*'))->forwardingURL('https://example.com/new', 301)->disable();

        $response = $client->pageRules()->update('zone_id', 'page_rule_id', $config);

        $this->assertTrue($response->successful());
        $this->assertSame('PUT', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/zones/zone_id/pagerules/page_rule_id', $this->lastRequest()->getUri()->getPath());
        $this->assertSame($config->toArray(), json_decode((string) $this->lastRequest()->getBody(), true));
    }

    /**
     * The array form is passed to Cloudflare as given, so the required keys are
     * checked here rather than by the API.
     */
    #[TestWith(['create', ['zone_id']])]
    #[TestWith(['edit', ['zone_id', 'page_rule_id']])]
    #[TestWith(['update', ['zone_id', 'page_rule_id']])]
    #[Test]
    public function shouldThrowWhenRequiredParamsAreMissing(string $method, array $arguments)
    {
        $client = $this->mockClient([]);

        $this->expectException(MissingArgumentException::class);

        $client->pageRules()->{$method}(...[...$arguments, ['actions' => [['id' => 'always_use_https']]]]);
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
