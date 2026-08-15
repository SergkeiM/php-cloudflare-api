<?php

namespace Cloudflare\Tests\Endpoints\Zones\Settings;

use Cloudflare\Exceptions\MissingArgumentException;
use Cloudflare\Tests\Concerns\InteractsWithMockClient;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\Test;

class ZarazTest extends TestCase
{
    use InteractsWithMockClient;

    /**
     * A complete-enough configuration body for the update endpoint.
     *
     * @return array
     */
    private function config(): array
    {
        return [
            'dataLayer' => true,
            'debugKey' => 'debug_key',
            'settings' => ['autoInjectScript' => true],
            'triggers' => ['trigger_id' => ['name' => 'Pageview']],
            'variables' => ['variable_id' => ['name' => 'Title', 'type' => 'string']],
            'tools' => ['tool_id' => ['name' => 'Analytics', 'enabled' => true]],
            'zarazVersion' => 45,
        ];
    }

    #[Test]
    public function shouldGetConfig()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode([
                'success' => true,
                'result' => [
                    'zarazVersion' => 45,
                    'debugKey' => 'debug_key',
                ],
            ])),
        ]);

        $response = $client->zones()->settings()->zaraz()->getConfig('zone_id');

        $this->assertTrue($response->successful());
        $this->assertSame(45, $response->json('result.zarazVersion'));

        $this->assertSame('GET', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/zones/zone_id/settings/zaraz/config', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldUpdateConfig()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode([
                'success' => true,
                'result' => ['zarazVersion' => 46],
            ])),
        ]);

        $response = $client->zones()->settings()->zaraz()->updateConfig('zone_id', $this->config());

        $this->assertTrue($response->successful());

        $this->assertSame('PUT', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/zones/zone_id/settings/zaraz/config', $this->lastRequest()->getUri()->getPath());
        $this->assertSame($this->config(), json_decode((string) $this->lastRequest()->getBody(), true));
    }

    #[Test]
    public function shouldThrowWhenConfigIsIncomplete()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true])),
        ]);

        $this->expectException(MissingArgumentException::class);

        $client->zones()->settings()->zaraz()->updateConfig('zone_id', [
            'debugKey' => 'debug_key',
        ]);
    }

    #[Test]
    public function shouldGetDefaultConfig()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode([
                'success' => true,
                'result' => ['zarazVersion' => 1],
            ])),
        ]);

        $response = $client->zones()->settings()->zaraz()->getDefault('zone_id');

        $this->assertTrue($response->successful());

        $this->assertSame('GET', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/zones/zone_id/settings/zaraz/default', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldExportConfig()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode([
                'success' => true,
                'result' => ['zarazVersion' => 45],
            ])),
        ]);

        $response = $client->zones()->settings()->zaraz()->export('zone_id');

        $this->assertTrue($response->successful());

        $this->assertSame('GET', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/zones/zone_id/settings/zaraz/export', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldListHistory()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode([
                'success' => true,
                'result' => [
                    ['id' => 1, 'description' => 'Initial'],
                ],
            ])),
        ]);

        $response = $client->zones()->settings()->zaraz()->history('zone_id', [
            'limit' => 5,
            'sortOrder' => 'ASC',
        ]);

        $this->assertTrue($response->successful());
        $this->assertSame(1, $response->json('result.0.id'));

        $this->assertSame('GET', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/zones/zone_id/settings/zaraz/history', $this->lastRequest()->getUri()->getPath());
        $this->assertSame('limit=5&sortOrder=ASC', $this->lastRequest()->getUri()->getQuery());
    }

    #[Test]
    public function shouldRestoreHistoricalConfigFromBareJsonNumber()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode([
                'success' => true,
                'result' => ['id' => 7],
            ])),
        ]);

        $response = $client->zones()->settings()->zaraz()->restore('zone_id', 7);

        $this->assertTrue($response->successful());

        $this->assertSame('PUT', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/zones/zone_id/settings/zaraz/history', $this->lastRequest()->getUri()->getPath());
        $this->assertSame('7', (string) $this->lastRequest()->getBody());
    }

    #[Test]
    public function shouldGetHistoricalConfigsByCommaSeparatedIds()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode([
                'success' => true,
                'result' => [['id' => 1], ['id' => 2]],
            ])),
        ]);

        $response = $client->zones()->settings()->zaraz()->configs('zone_id', [1, 2]);

        $this->assertTrue($response->successful());

        $this->assertSame('GET', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/zones/zone_id/settings/zaraz/history/configs', $this->lastRequest()->getUri()->getPath());
        $this->assertSame('ids=1%2C2', $this->lastRequest()->getUri()->getQuery());
    }

    #[Test]
    public function shouldThrowWhenNoConfigIdsGiven()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true])),
        ]);

        $this->expectException(MissingArgumentException::class);

        $client->zones()->settings()->zaraz()->configs('zone_id', []);
    }

    #[Test]
    public function shouldGetWorkflow()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode([
                'success' => true,
                'result' => 'realtime',
            ])),
        ]);

        $response = $client->zones()->settings()->zaraz()->getWorkflow('zone_id');

        $this->assertTrue($response->successful());
        $this->assertSame('realtime', $response->json('result'));

        $this->assertSame('GET', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/zones/zone_id/settings/zaraz/workflow', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldUpdateWorkflowWithBareJsonString()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode([
                'success' => true,
                'result' => 'preview',
            ])),
        ]);

        $response = $client->zones()->settings()->zaraz()->updateWorkflow('zone_id', 'preview');

        $this->assertTrue($response->successful());

        $this->assertSame('PUT', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/zones/zone_id/settings/zaraz/workflow', $this->lastRequest()->getUri()->getPath());
        $this->assertSame('"preview"', (string) $this->lastRequest()->getBody());
    }

    #[Test]
    public function shouldPublishWithBareJsonString()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode([
                'success' => true,
                'result' => ['zarazVersion' => 46],
            ])),
        ]);

        $response = $client->zones()->settings()->zaraz()->publish('zone_id', 'Enable analytics');

        $this->assertTrue($response->successful());

        $this->assertSame('POST', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/zones/zone_id/settings/zaraz/publish', $this->lastRequest()->getUri()->getPath());
        $this->assertSame('"Enable analytics"', (string) $this->lastRequest()->getBody());
    }
}
