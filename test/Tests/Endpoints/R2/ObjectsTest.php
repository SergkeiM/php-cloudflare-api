<?php

namespace Cloudflare\Tests\Endpoints\R2;

use Cloudflare\Tests\Concerns\InteractsWithMockClient;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\Test;

class ObjectsTest extends TestCase
{
    use InteractsWithMockClient;

    #[Test]
    public function shouldListObjects()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode([
                'success' => true,
                'result' => [
                    ['key' => 'path/to/file.txt', 'size' => 12],
                ],
            ])),
        ]);

        $response = $client->r2()->objects()->list('account_id', 'my-bucket', [
            'prefix' => 'path/',
            'per_page' => 50,
        ]);

        $this->assertTrue($response->successful());
        $this->assertSame('path/to/file.txt', $response->json('result.0.key'));

        $this->assertSame('GET', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/accounts/account_id/r2/buckets/my-bucket/objects', $this->lastRequest()->getUri()->getPath());
        $this->assertSame('prefix=path%2F&per_page=50', $this->lastRequest()->getUri()->getQuery());
    }

    /**
     * The response is the object itself rather than a JSON envelope, so the
     * body has to survive untouched.
     */
    #[Test]
    public function shouldGetObjectBodyVerbatim()
    {
        $client = $this->mockClient([
            new Response(200, ['Content-Type' => 'text/plain'], 'file contents'),
        ]);

        $response = $client->r2()->objects()->get('account_id', 'my-bucket', 'path/to/file.txt');

        $this->assertTrue($response->successful());
        $this->assertSame('file contents', $response->body());

        $this->assertSame('GET', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/accounts/account_id/r2/buckets/my-bucket/objects/path/to/file.txt', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldUploadObject()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode([
                'success' => true,
                'result' => ['key' => 'path/to/file.txt'],
            ])),
        ]);

        $response = $client->r2()->objects()->upload('account_id', 'my-bucket', 'path/to/file.txt', 'file contents', 'text/plain');

        $this->assertTrue($response->successful());

        $this->assertSame('PUT', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/accounts/account_id/r2/buckets/my-bucket/objects/path/to/file.txt', $this->lastRequest()->getUri()->getPath());
        $this->assertSame('file contents', (string) $this->lastRequest()->getBody());
        $this->assertSame('text/plain', $this->lastRequest()->getHeaderLine('Content-Type'));
    }

    #[Test]
    public function shouldUploadObjectWithStorageClassAndJurisdiction()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => []])),
        ]);

        $response = $client->r2()->objects()->upload(
            'account_id',
            'my-bucket',
            'file.bin',
            'bytes',
            'application/octet-stream',
            'InfrequentAccess',
            'eu'
        );

        $this->assertTrue($response->successful());
        $this->assertSame('InfrequentAccess', $this->lastRequest()->getHeaderLine('cf-r2-storage-class'));
        $this->assertSame('eu', $this->lastRequest()->getHeaderLine('cf-r2-jurisdiction'));
    }

    #[Test]
    public function shouldDeleteSingleObject()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => null])),
        ]);

        $response = $client->r2()->objects()->delete('account_id', 'my-bucket', 'path/to/file.txt');

        $this->assertTrue($response->successful());

        $this->assertSame('DELETE', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/accounts/account_id/r2/buckets/my-bucket/objects/path/to/file.txt', $this->lastRequest()->getUri()->getPath());
    }

    /**
     * Delete-by-list sends a bare JSON array of keys, not an object wrapping
     * them, and that is what distinguishes it from the prefix modes.
     */
    #[Test]
    public function shouldDeleteManyObjectsWithBareJsonArrayBody()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode([
                'success' => true,
                'result' => ['deleted' => 2],
            ])),
        ]);

        $response = $client->r2()->objects()->deleteMany('account_id', 'my-bucket', [
            'path/to/a.txt',
            'path/to/b.txt',
        ]);

        $this->assertTrue($response->successful());

        $this->assertSame('DELETE', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/accounts/account_id/r2/buckets/my-bucket/objects', $this->lastRequest()->getUri()->getPath());
        $this->assertSame('["path\/to\/a.txt","path\/to\/b.txt"]', (string) $this->lastRequest()->getBody());
    }

    /**
     * Keys arrive as a list even when the caller passes a map with gaps in it,
     * since a JSON object here would be read as the wrong delete mode.
     */
    #[Test]
    public function shouldSendNonSequentialKeysAsAJsonArray()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => []])),
        ]);

        $client->r2()->objects()->deleteMany('account_id', 'my-bucket', [
            3 => 'path/to/a.txt',
            7 => 'path/to/b.txt',
        ]);

        $this->assertSame('["path\/to\/a.txt","path\/to\/b.txt"]', (string) $this->lastRequest()->getBody());
    }

    #[Test]
    public function shouldDeleteByPrefix()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode([
                'success' => true,
                'result' => ['id' => 'job_id', 'status' => 'RUNNING'],
            ])),
        ]);

        $response = $client->r2()->objects()->deleteByPrefix('account_id', 'my-bucket', 'path/');

        $this->assertTrue($response->successful());
        $this->assertSame('job_id', $response->json('result.id'));

        $this->assertSame('DELETE', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/accounts/account_id/r2/buckets/my-bucket/objects', $this->lastRequest()->getUri()->getPath());
        $this->assertSame('prefix=path%2F', $this->lastRequest()->getUri()->getQuery());
        $this->assertSame('', (string) $this->lastRequest()->getBody());
    }

    #[Test]
    public function shouldSendDataCatalogCheckHeaderWhenAsked()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => []])),
        ]);

        $client->r2()->objects()->deleteByPrefix('account_id', 'my-bucket', 'path/', true);

        $this->assertSame('true', $this->lastRequest()->getHeaderLine('cf-r2-data-catalog-check'));
    }

    /**
     * Emptying a bucket is the same operation with an empty prefix, so the
     * query parameter has to be present but blank.
     */
    #[Test]
    public function shouldEmptyBucketWithBlankPrefix()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode([
                'success' => true,
                'result' => ['id' => 'job_id', 'status' => 'ENQUEUED'],
            ])),
        ]);

        $response = $client->r2()->objects()->emptyBucket('account_id', 'my-bucket');

        $this->assertTrue($response->successful());
        $this->assertSame('ENQUEUED', $response->json('result.status'));

        $this->assertSame('DELETE', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/accounts/account_id/r2/buckets/my-bucket/objects', $this->lastRequest()->getUri()->getPath());
        $this->assertSame('prefix=', $this->lastRequest()->getUri()->getQuery());
        $this->assertSame('', (string) $this->lastRequest()->getBody());
    }
}
