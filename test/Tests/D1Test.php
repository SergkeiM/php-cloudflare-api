<?php

namespace Cloudflare\Tests;

use Cloudflare\Exceptions\MissingArgumentException;
use Cloudflare\Tests\Concerns\InteractsWithMockClient;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class D1Test extends TestCase
{
    use InteractsWithMockClient;

    #[Test]
    public function shouldList()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => [['uuid' => 'database_id']]])),
        ]);

        $response = $client->d1()->list('account_id');

        $this->assertTrue($response->successful());
        $this->assertSame('GET', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/accounts/account_id/d1/database', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldCreateWithoutLocation()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => ['uuid' => 'database_id']])),
        ]);

        $response = $client->d1()->create('account_id', ['name' => 'my-database']);

        $this->assertTrue($response->successful());
        $this->assertSame('POST', $this->lastRequest()->getMethod());
        $this->assertSame(['name' => 'my-database'], json_decode((string) $this->lastRequest()->getBody(), true));
    }

    #[Test]
    public function shouldCreateWithLocation()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => ['uuid' => 'database_id']])),
        ]);

        $response = $client->d1()->create('account_id', ['name' => 'my-database', 'primary_location_hint' => 'wnam']);

        $this->assertTrue($response->successful());
        $this->assertSame([
            'name' => 'my-database',
            'primary_location_hint' => 'wnam',
        ], json_decode((string) $this->lastRequest()->getBody(), true));
    }

    #[Test]
    public function shouldGetDetails()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => ['uuid' => 'database_id']])),
        ]);

        $response = $client->d1()->get('account_id', 'database_id');

        $this->assertTrue($response->successful());
        $this->assertSame('GET', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/accounts/account_id/d1/database/database_id', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldDelete()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => null])),
        ]);

        $response = $client->d1()->delete('account_id', 'database_id');

        $this->assertTrue($response->successful());
        $this->assertSame('DELETE', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/accounts/account_id/d1/database/database_id', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldExportWithoutBookmark()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => ['success' => true]])),
        ]);

        $response = $client->d1()->export('account_id', 'database_id');

        $this->assertTrue($response->successful());
        $this->assertSame('POST', $this->lastRequest()->getMethod());
        $body = json_decode((string) $this->lastRequest()->getBody(), true);
        $this->assertArrayNotHasKey('current_bookmark', $body);
    }

    #[Test]
    public function shouldExportWithBookmark()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => ['success' => true]])),
        ]);

        $response = $client->d1()->export('account_id', 'database_id', 'bookmark_1', true, true, ['table1']);

        $this->assertTrue($response->successful());
        $body = json_decode((string) $this->lastRequest()->getBody(), true);
        $this->assertSame('bookmark_1', $body['current_bookmark']);
    }

    #[Test]
    public function shouldImportInit()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => ['success' => true]])),
        ]);

        $response = $client->d1()->import('account_id', 'database_id', 'init', 'etag_value');

        $this->assertTrue($response->successful());
        $body = json_decode((string) $this->lastRequest()->getBody(), true);
        $this->assertSame('etag_value', $body['etag']);
    }

    #[Test]
    public function shouldImportIngest()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => ['success' => true]])),
        ]);

        $response = $client->d1()->import('account_id', 'database_id', 'ingest', 'etag_value', 'filename.sql');

        $this->assertTrue($response->successful());
        $body = json_decode((string) $this->lastRequest()->getBody(), true);
        $this->assertSame('filename.sql', $body['filename']);
        $this->assertSame('etag_value', $body['etag']);
    }

    #[Test]
    public function shouldImportPoll()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => ['success' => true]])),
        ]);

        $response = $client->d1()->import('account_id', 'database_id', 'poll', null, null, 'bookmark_1');

        $this->assertTrue($response->successful());
        $body = json_decode((string) $this->lastRequest()->getBody(), true);
        $this->assertSame('bookmark_1', $body['current_bookmark']);
    }

    #[Test]
    public function shouldThrowWhenIngestMissingFilename()
    {
        $client = $this->mockClient([]);

        $this->expectException(MissingArgumentException::class);

        $client->d1()->import('account_id', 'database_id', 'ingest', 'etag_value');
    }

    #[Test]
    public function shouldThrowWhenPollMissingBookmark()
    {
        $client = $this->mockClient([]);

        $this->expectException(MissingArgumentException::class);

        $client->d1()->import('account_id', 'database_id', 'poll');
    }

    #[Test]
    public function shouldThrowWhenInitMissingEtag()
    {
        $client = $this->mockClient([]);

        $this->expectException(MissingArgumentException::class);

        $client->d1()->import('account_id', 'database_id', 'init');
    }

    #[Test]
    public function shouldQuery()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => [['results' => []]]])),
        ]);

        $response = $client->d1()->query('account_id', 'database_id', 'SELECT * FROM table1', ['param1']);

        $this->assertTrue($response->successful());
        $this->assertSame('POST', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/accounts/account_id/d1/database/database_id/query', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldRaw()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => [['results' => []]]])),
        ]);

        $response = $client->d1()->raw('account_id', 'database_id', 'SELECT * FROM table1');

        $this->assertTrue($response->successful());
        $this->assertSame('POST', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/accounts/account_id/d1/database/database_id/raw', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldUpdateDatabase()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode([
                'success' => true,
                'result' => ['uuid' => 'database_id', 'read_replication' => ['mode' => 'auto']],
            ])),
        ]);

        $response = $client->d1()->update('account_id', 'database_id', [
            'read_replication' => ['mode' => 'auto'],
        ]);

        $this->assertTrue($response->successful());
        $this->assertSame('auto', $response->json('result.read_replication.mode'));

        $this->assertSame('PUT', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/accounts/account_id/d1/database/database_id', $this->lastRequest()->getUri()->getPath());
        $this->assertSame(['read_replication' => ['mode' => 'auto']], json_decode((string) $this->lastRequest()->getBody(), true));
    }

    #[Test]
    public function shouldThrowWhenUpdatingWithoutReadReplication()
    {
        $client = $this->mockClient([]);

        $this->expectException(MissingArgumentException::class);

        $client->d1()->update('account_id', 'database_id', []);
    }

    #[Test]
    public function shouldEditDatabase()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode([
                'success' => true,
                'result' => ['uuid' => 'database_id'],
            ])),
        ]);

        $response = $client->d1()->edit('account_id', 'database_id', [
            'read_replication' => ['mode' => 'disabled'],
        ]);

        $this->assertTrue($response->successful());

        $this->assertSame('PATCH', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/accounts/account_id/d1/database/database_id', $this->lastRequest()->getUri()->getPath());
        $this->assertSame(['read_replication' => ['mode' => 'disabled']], json_decode((string) $this->lastRequest()->getBody(), true));
    }

    #[Test]
    public function shouldGetCurrentBookmark()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode([
                'success' => true,
                'result' => ['bookmark' => '00000085-0000034c-00004c1f'],
            ])),
        ]);

        $response = $client->d1()->bookmark('account_id', 'database_id');

        $this->assertTrue($response->successful());
        $this->assertSame('00000085-0000034c-00004c1f', $response->json('result.bookmark'));

        $this->assertSame('GET', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/accounts/account_id/d1/database/database_id/time_travel/bookmark', $this->lastRequest()->getUri()->getPath());
        $this->assertSame('', $this->lastRequest()->getUri()->getQuery());
    }

    #[Test]
    public function shouldGetBookmarkNearestToATimestamp()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => ['bookmark' => 'bookmark']])),
        ]);

        $client->d1()->bookmark('account_id', 'database_id', '2026-08-15T00:00:00Z');

        $this->assertSame('timestamp=2026-08-15T00%3A00%3A00Z', $this->lastRequest()->getUri()->getQuery());
    }

    #[Test]
    public function shouldRestoreFromBookmark()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => ['bookmark' => 'bookmark']])),
        ]);

        $response = $client->d1()->restore('account_id', 'database_id', bookmark: 'bookmark');

        $this->assertTrue($response->successful());

        $this->assertSame('POST', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/accounts/account_id/d1/database/database_id/time_travel/restore', $this->lastRequest()->getUri()->getPath());
        $this->assertSame('bookmark=bookmark', $this->lastRequest()->getUri()->getQuery());
    }

    #[Test]
    public function shouldRestoreFromTimestamp()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => []])),
        ]);

        $client->d1()->restore('account_id', 'database_id', timestamp: '2026-08-15T00:00:00Z');

        $this->assertSame('timestamp=2026-08-15T00%3A00%3A00Z', $this->lastRequest()->getUri()->getQuery());
    }

    #[Test]
    public function shouldThrowWhenRestoringWithoutBookmarkOrTimestamp()
    {
        $client = $this->mockClient([]);

        $this->expectException(MissingArgumentException::class);

        $client->d1()->restore('account_id', 'database_id');
    }

    #[Test]
    public function shouldCreateWithReadReplication()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => ['uuid' => 'database_id']])),
        ]);

        $values = [
            'name' => 'my-database',
            'read_replication' => ['mode' => 'auto'],
        ];

        $response = $client->d1()->create('account_id', $values);

        $this->assertTrue($response->successful());
        $this->assertSame($values, json_decode((string) $this->lastRequest()->getBody(), true));
    }

    #[Test]
    public function shouldThrowWhenCreatingDatabaseWithoutName()
    {
        $client = $this->mockClient([]);

        $this->expectException(MissingArgumentException::class);

        $client->d1()->create('account_id', []);
    }
}
