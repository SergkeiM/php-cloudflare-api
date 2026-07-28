<?php

namespace Cloudflare\Tests\Endpoints\Zones;

use Cloudflare\Exceptions\MissingArgumentException;
use Cloudflare\Tests\Concerns\InteractsWithMockClient;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class DNSTest extends TestCase
{
    use InteractsWithMockClient;

    #[Test]
    public function shouldScan()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => []])),
        ]);

        $response = $client->zones()->dns()->scan('zone_id');

        $this->assertTrue($response->successful());
        $this->assertSame('POST', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/zones/zone_id/dns_records/scan', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldList()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => [['id' => 'record_id']]])),
        ]);

        $response = $client->zones()->dns()->list('zone_id');

        $this->assertTrue($response->successful());
        $this->assertSame('record_id', $response->json('result.0.id'));
        $this->assertSame('GET', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/zones/zone_id/dns_records', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldCreate()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => ['id' => 'record_id']])),
        ]);

        $response = $client->zones()->dns()->create('zone_id', [
            'type' => 'A',
            'name' => 'example.com',
            'content' => '127.0.0.1',
        ]);

        $this->assertTrue($response->successful());
        $this->assertSame('POST', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/zones/zone_id/dns_records', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldThrowWhenCreateMissingRequiredParams()
    {
        $client = $this->mockClient([]);

        $this->expectException(MissingArgumentException::class);

        $client->zones()->dns()->create('zone_id', ['name' => 'example.com']);
    }

    #[Test]
    public function shouldExport()
    {
        $client = $this->mockClient([
            new Response(200, [], 'example.com. 300 IN A 127.0.0.1'),
        ]);

        $response = $client->zones()->dns()->export('zone_id');

        $this->assertTrue($response->successful());
        $this->assertSame('GET', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/zones/zone_id/dns_records/export', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldImport()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => ['recs_added' => 1]])),
        ]);

        $response = $client->zones()->dns()->import('zone_id', 'example.com. 300 IN A 127.0.0.1');

        $this->assertTrue($response->successful());
        $this->assertSame('POST', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/zones/zone_id/dns_records/import', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldGetDetails()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => ['id' => 'record_id']])),
        ]);

        $response = $client->zones()->dns()->details('zone_id', 'record_id');

        $this->assertTrue($response->successful());
        $this->assertSame('GET', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/zones/zone_id/dns_records/record_id', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldUpdate()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => ['id' => 'record_id']])),
        ]);

        $response = $client->zones()->dns()->update('zone_id', 'record_id', [
            'type' => 'A',
            'name' => 'example.com',
            'content' => '127.0.0.1',
        ]);

        $this->assertTrue($response->successful());
        $this->assertSame('PATCH', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/zones/zone_id/dns_records/record_id', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldOverwrite()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => ['id' => 'record_id']])),
        ]);

        $response = $client->zones()->dns()->overwrite('zone_id', 'record_id', [
            'type' => 'A',
            'name' => 'example.com',
            'content' => '127.0.0.1',
        ]);

        $this->assertTrue($response->successful());
        $this->assertSame('PUT', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/zones/zone_id/dns_records/record_id', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldDelete()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => ['id' => 'record_id']])),
        ]);

        $response = $client->zones()->dns()->delete('zone_id', 'record_id');

        $this->assertTrue($response->successful());
        $this->assertSame('DELETE', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/zones/zone_id/dns_records/record_id', $this->lastRequest()->getUri()->getPath());
    }
}
