<?php

namespace Cloudflare\Tests\Endpoints\Zones;

use Cloudflare\Tests\Concerns\InteractsWithMockClient;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\Test;

class TransformationFlowsTest extends TestCase
{
    use InteractsWithMockClient;

    /**
     * @return array
     */
    private function customFlow(): array
    {
        return [
            'type' => 'custom',
            'name' => 'Thumbnails',
            'enabled' => true,
            'trigger' => ['type' => 'path', 'paths' => ['/thumbs/*']],
            'transformations' => [['key' => 'width', 'value' => '200']],
        ];
    }

    #[Test]
    public function shouldGetFlows()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode([
                'success' => true,
                'result' => [
                    'etag' => 'etag_value',
                    'version' => 2,
                    'flows' => [['type' => 'provider', 'provider' => 'fastly']],
                ],
            ])),
        ]);

        $response = $client->zones()->transformationFlows()->get('account_id', 'zone_id');

        $this->assertTrue($response->successful());
        $this->assertSame('etag_value', $response->json('result.etag'));

        $this->assertSame('GET', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/accounts/account_id/zones/zone_id/v1/images/flows', $this->lastRequest()->getUri()->getPath());
    }

    /**
     * `version` is required and fixed at 2, so it goes out even though the
     * caller never mentions it.
     */
    #[Test]
    public function shouldUpdateFlowsWithTheRequiredVersion()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => ['version' => 2]])),
        ]);

        $response = $client->zones()->transformationFlows()->update('account_id', 'zone_id', ['flows' => [$this->customFlow()]]);

        $this->assertTrue($response->successful());

        $this->assertSame('PUT', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/accounts/account_id/zones/zone_id/v1/images/flows', $this->lastRequest()->getUri()->getPath());
        $this->assertSame([
            'flows' => [$this->customFlow()],
            'version' => 2,
        ], json_decode((string) $this->lastRequest()->getBody(), true));
    }

    #[Test]
    public function shouldSendEtagWhenGiven()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => []])),
        ]);

        $client->zones()->transformationFlows()->update('account_id', 'zone_id', ['flows' => [$this->customFlow()], 'etag' => 'etag_value']);

        $body = json_decode((string) $this->lastRequest()->getBody(), true);

        $this->assertSame('etag_value', $body['etag']);
    }

    /**
     * Omitting the etag has to leave the key out entirely rather than sending
     * a null, which Cloudflare would read as a conditional write against
     * nothing.
     */
    #[Test]
    public function shouldOmitEtagWhenNotGiven()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => []])),
        ]);

        $client->zones()->transformationFlows()->update('account_id', 'zone_id', ['flows' => [$this->customFlow()]]);

        $this->assertArrayNotHasKey('etag', json_decode((string) $this->lastRequest()->getBody(), true));
    }

    /**
     * An empty list is how the flows are cleared, and it has to encode as a
     * JSON array rather than an object.
     */
    #[Test]
    public function shouldClearFlowsWithAnEmptyList()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => []])),
        ]);

        $client->zones()->transformationFlows()->update('account_id', 'zone_id', ['flows' => []]);

        $this->assertSame('{"flows":[],"version":2}', (string) $this->lastRequest()->getBody());
    }

    #[Test]
    public function shouldSendNonSequentialFlowsAsAJsonArray()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => []])),
        ]);

        $client->zones()->transformationFlows()->update('account_id', 'zone_id', [
            'flows' => [3 => $this->customFlow()],
        ]);

        $body = json_decode((string) $this->lastRequest()->getBody(), true);

        $this->assertSame([$this->customFlow()], $body['flows']);
    }
}
