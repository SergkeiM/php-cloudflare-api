<?php

namespace Cloudflare\Tests\Endpoints;

use Cloudflare\Configurations\Zones\CachePurge;
use Cloudflare\Exceptions\MissingArgumentException;
use Cloudflare\Endpoints\Zones\Cache;
use Cloudflare\Tests\Concerns\InteractsWithMockClient;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class ZonesTest extends TestCase
{
    use InteractsWithMockClient;

    #[Test]
    public function shouldList()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => [['id' => 'zone_id']]])),
        ]);

        $response = $client->zones()->list('account_id');

        $this->assertTrue($response->successful());
        $this->assertSame('GET', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/zones', $this->lastRequest()->getUri()->getPath());
        $this->assertStringContainsString('account%5Bid%5D=account_id', $this->lastRequest()->getUri()->getQuery());
    }

    #[Test]
    public function shouldCreate()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => ['id' => 'zone_id']])),
        ]);

        $response = $client->zones()->create('account_id', 'example.com');

        $this->assertTrue($response->successful());
        $this->assertSame('POST', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/zones', $this->lastRequest()->getUri()->getPath());
        $this->assertSame([
            'name' => 'example.com',
            'account' => ['id' => 'account_id'],
            'type' => 'full',
        ], json_decode((string) $this->lastRequest()->getBody(), true));
    }

    #[Test]
    public function shouldGetDetails()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => ['id' => 'zone_id']])),
        ]);

        $response = $client->zones()->details('zone_id');

        $this->assertTrue($response->successful());
        $this->assertSame('GET', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/zones/zone_id', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldDelete()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => ['id' => 'zone_id']])),
        ]);

        $response = $client->zones()->delete('zone_id');

        $this->assertTrue($response->successful());
        $this->assertSame('DELETE', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/zones/zone_id', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldUpdateWithoutVanityNameServers()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => ['id' => 'zone_id']])),
        ]);

        $response = $client->zones()->update('zone_id', 'full');

        $this->assertTrue($response->successful());
        $this->assertSame('PATCH', $this->lastRequest()->getMethod());
        $this->assertSame(['type' => 'full'], json_decode((string) $this->lastRequest()->getBody(), true));
    }

    #[Test]
    public function shouldUpdateWithVanityNameServers()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => ['id' => 'zone_id']])),
        ]);

        $response = $client->zones()->update('zone_id', 'full', ['ns1.example.com']);

        $this->assertTrue($response->successful());
        $this->assertSame([
            'type' => 'full',
            'vanity_name_servers' => ['ns1.example.com'],
        ], json_decode((string) $this->lastRequest()->getBody(), true));
    }

    #[Test]
    public function shouldActivationCheck()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => ['id' => 'zone_id']])),
        ]);

        $response = $client->zones()->activationCheck('zone_id');

        $this->assertTrue($response->successful());
        $this->assertSame('PUT', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/zones/zone_id/activation_check', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldPurgeWithArray()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => ['id' => 'zone_id']])),
        ]);

        $response = $client->zones()->purge('zone_id', ['tags' => ['my-tag']]);

        $this->assertTrue($response->successful());
        $this->assertSame('POST', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/zones/zone_id/purge_cache', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldPurgeWithCachePurgeObject()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => ['id' => 'zone_id']])),
        ]);

        $config = (new CachePurge())->everything();

        $response = $client->zones()->purge('zone_id', $config);

        $this->assertTrue($response->successful());
        $this->assertSame('POST', $this->lastRequest()->getMethod());
        $this->assertSame(['purge_everything' => true], json_decode((string) $this->lastRequest()->getBody(), true));
    }

    #[Test]
    public function shouldThrowWhenPurgeMissingAnyRequiredParams()
    {
        $client = $this->mockClient([]);

        $this->expectException(MissingArgumentException::class);

        $client->zones()->purge('zone_id', []);
    }

    #[Test]
    public function shouldGetCache()
    {
        $client = $this->mockClient([]);

        $this->assertInstanceOf(Cache::class, $client->zones()->cache());
    }
}
