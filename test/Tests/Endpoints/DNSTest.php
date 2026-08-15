<?php

namespace Cloudflare\Tests\Endpoints;

use Cloudflare\Exceptions\MissingArgumentException;
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

    #[Test]
    public function shouldTriggerScan()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => null])),
        ]);

        $response = $client->dns()->triggerScan('zone_id');

        $this->assertTrue($response->successful());
        $this->assertSame('POST', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/zones/zone_id/dns_records/scan/trigger', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldListScannedRecords()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode([
                'success' => true,
                'result' => [
                    ['id' => 'scanned_id', 'type' => 'A', 'name' => 'www.example.com'],
                ],
            ])),
        ]);

        $response = $client->dns()->scannedRecords('zone_id');

        $this->assertTrue($response->successful());
        $this->assertSame('scanned_id', $response->json('result.0.id'));

        $this->assertSame('GET', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/zones/zone_id/dns_records/scan/review', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldReviewScan()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => null])),
        ]);

        $response = $client->dns()->reviewScan('zone_id', ['accept_id'], ['reject_id']);

        $this->assertTrue($response->successful());

        $this->assertSame('POST', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/zones/zone_id/dns_records/scan/review', $this->lastRequest()->getUri()->getPath());
        $this->assertSame([
            'accepts' => ['accept_id'],
            'rejects' => ['reject_id'],
        ], json_decode((string) $this->lastRequest()->getBody(), true));
    }

    /**
     * Reviewing only accepts, or only rejects, is a legitimate request — but
     * reviewing nothing at all is not.
     */
    #[Test]
    public function shouldReviewScanWithAcceptsOnly()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => null])),
        ]);

        $response = $client->dns()->reviewScan('zone_id', ['accept_id']);

        $this->assertTrue($response->successful());
        $this->assertSame([
            'accepts' => ['accept_id'],
            'rejects' => [],
        ], json_decode((string) $this->lastRequest()->getBody(), true));
    }

    #[Test]
    public function shouldThrowWhenReviewingNothing()
    {
        $client = $this->mockClient([]);

        $this->expectException(MissingArgumentException::class);

        $client->dns()->reviewScan('zone_id');
    }

    #[Test]
    public function shouldBatchRecordChanges()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode([
                'success' => true,
                'result' => ['posts' => [['id' => 'record_id']]],
            ])),
        ]);

        $values = [
            'posts' => [['type' => 'A', 'name' => 'www', 'content' => '198.51.100.4']],
            'deletes' => [['id' => 'record_id']],
        ];

        $response = $client->dns()->batch('zone_id', $values);

        $this->assertTrue($response->successful());

        $this->assertSame('POST', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/zones/zone_id/dns_records/batch', $this->lastRequest()->getUri()->getPath());
        $this->assertSame($values, json_decode((string) $this->lastRequest()->getBody(), true));
    }

    #[Test]
    public function shouldBatchWithQueryParameters()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => []])),
        ]);

        $client->dns()->batch('zone_id', [
            'puts' => [['id' => 'record_id', 'type' => 'A', 'name' => 'www', 'content' => '198.51.100.5']],
        ], ['include_shadow_metadata' => 'true']);

        $this->assertSame('include_shadow_metadata=true', $this->lastRequest()->getUri()->getQuery());
    }

    #[Test]
    public function shouldThrowWhenBatchHasNoOperations()
    {
        $client = $this->mockClient([]);

        $this->expectException(MissingArgumentException::class);

        $client->dns()->batch('zone_id', ['unknown' => []]);
    }

    #[Test]
    public function shouldGetAccountUsage()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode([
                'success' => true,
                'result' => ['quota' => 3500, 'usage' => 12],
            ])),
        ]);

        $response = $client->dns()->usage('account_id');

        $this->assertTrue($response->successful());
        $this->assertSame(3500, $response->json('result.quota'));

        $this->assertSame('GET', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/accounts/account_id/dns_records/usage', $this->lastRequest()->getUri()->getPath());
    }
}
