<?php

namespace Cloudflare\Tests\Endpoints;

use Cloudflare\Tests\Concerns\InteractsWithMockClient;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\Test;

class DNSTest extends TestCase
{
    use InteractsWithMockClient;

    #[Test]
    public function shouldScan()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => []])),
        ]);

        $response = $client->dns()->scan('zone_id');

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

        $response = $client->dns()->list('zone_id');

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

        $response = $client->dns()->create('zone_id', [
            'content' => '192.0.2.1',
            'name' => 'example.com',
            'type' => 'A',
        ]);

        $this->assertTrue($response->successful());
        $this->assertSame('POST', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/zones/zone_id/dns_records', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldExport()
    {
        $client = $this->mockClient([
            new Response(200, [], 'zone file contents'),
        ]);

        $response = $client->dns()->export('zone_id');

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

        $response = $client->dns()->import('zone_id', 'example.com. 1 IN A 192.0.2.1');

        $this->assertTrue($response->successful());
        $this->assertSame('POST', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/zones/zone_id/dns_records/import', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldGet()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => ['id' => 'record_id']])),
        ]);

        $response = $client->dns()->get('zone_id', 'record_id');

        $this->assertTrue($response->successful());
        $this->assertSame('GET', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/zones/zone_id/dns_records/record_id', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldEdit()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => ['id' => 'record_id']])),
        ]);

        $response = $client->dns()->edit('zone_id', 'record_id', [
            'content' => '192.0.2.2',
            'name' => 'example.com',
            'type' => 'A',
        ]);

        $this->assertTrue($response->successful());
        $this->assertSame('PATCH', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/zones/zone_id/dns_records/record_id', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldUpdate()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => ['id' => 'record_id']])),
        ]);

        $response = $client->dns()->update('zone_id', 'record_id', [
            'content' => '192.0.2.2',
            'name' => 'example.com',
            'type' => 'A',
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

        $response = $client->dns()->delete('zone_id', 'record_id');

        $this->assertTrue($response->successful());
        $this->assertSame('DELETE', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/zones/zone_id/dns_records/record_id', $this->lastRequest()->getUri()->getPath());
    }
}
