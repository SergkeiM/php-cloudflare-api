<?php

namespace Cloudflare\Tests\Endpoints\Zones;

use Cloudflare\Tests\Concerns\InteractsWithMockClient;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\Test;

class FiltersTest extends TestCase
{
    use InteractsWithMockClient;

    #[Test]
    public function shouldListFilters()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode([
                'success' => true,
                'result' => [
                    ['id' => 'filter_id'],
                ],
            ])),
        ]);

        $response = $client->zones()->filters()->list('zone_id');

        $this->assertTrue($response->successful());
        $this->assertSame('filter_id', $response->json('result.0.id'));

        $this->assertSame('GET', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/zones/zone_id/filters', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldGetFilterDetails()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode([
                'success' => true,
                'result' => [
                    'id' => 'filter_id',
                ],
            ])),
        ]);

        $response = $client->zones()->filters()->details('zone_id', 'filter_id');

        $this->assertTrue($response->successful());
        $this->assertSame('filter_id', $response->json('result.id'));

        $this->assertSame('GET', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/zones/zone_id/filters/filter_id', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldCreateFilters()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode([
                'success' => true,
                'result' => [
                    ['id' => 'filter_id'],
                ],
            ])),
        ]);

        $response = $client->zones()->filters()->create('zone_id', [
            ['expression' => 'ip.src eq 127.0.0.1'],
        ]);

        $this->assertTrue($response->successful());
        $this->assertSame('filter_id', $response->json('result.0.id'));

        $this->assertSame('POST', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/zones/zone_id/filters', $this->lastRequest()->getUri()->getPath());
        $this->assertSame([
            ['expression' => 'ip.src eq 127.0.0.1'],
        ], json_decode((string) $this->lastRequest()->getBody(), true));
    }

    #[Test]
    public function shouldUpdateFilter()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode([
                'success' => true,
                'result' => [
                    'id' => 'filter_id',
                    'paused' => true,
                ],
            ])),
        ]);

        $response = $client->zones()->filters()->update('zone_id', 'filter_id', [
            'expression' => 'ip.src eq 127.0.0.1',
            'paused' => true,
        ]);

        $this->assertTrue($response->successful());
        $this->assertTrue($response->json('result.paused'));

        $this->assertSame('PUT', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/zones/zone_id/filters/filter_id', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldDeleteFilter()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode([
                'success' => true,
                'result' => [
                    'id' => 'filter_id',
                ],
            ])),
        ]);

        $response = $client->zones()->filters()->delete('zone_id', 'filter_id');

        $this->assertTrue($response->successful());

        $this->assertSame('DELETE', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/zones/zone_id/filters/filter_id', $this->lastRequest()->getUri()->getPath());
    }
}
