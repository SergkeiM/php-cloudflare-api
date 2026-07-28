<?php

namespace Cloudflare\Tests\Endpoints\Accounts;

use Cloudflare\Tests\Concerns\InteractsWithMockClient;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\Test;

class R2BucketsTest extends TestCase
{
    use InteractsWithMockClient;

    #[Test]
    public function shouldListBuckets()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode([
                'success' => true,
                'result' => [
                    'buckets' => [
                        ['name' => 'my-bucket'],
                    ],
                ],
            ])),
        ]);

        $response = $client->accounts()->r2Buckets()->list('account_id');

        $this->assertTrue($response->successful());
        $this->assertSame('my-bucket', $response->json('result.buckets.0.name'));

        $this->assertSame('GET', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/accounts/account_id/r2/buckets', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldCreateBucket()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode([
                'success' => true,
                'result' => [
                    'name' => 'my-bucket',
                ],
            ])),
        ]);

        $response = $client->accounts()->r2Buckets()->create('account_id', [
            'name' => 'my-bucket',
        ]);

        $this->assertTrue($response->successful());
        $this->assertSame('my-bucket', $response->json('result.name'));

        $this->assertSame('POST', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/accounts/account_id/r2/buckets', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldGetBucketDetails()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode([
                'success' => true,
                'result' => [
                    'name' => 'my-bucket',
                ],
            ])),
        ]);

        $response = $client->accounts()->r2Buckets()->details('account_id', 'my-bucket');

        $this->assertTrue($response->successful());
        $this->assertSame('my-bucket', $response->json('result.name'));

        $this->assertSame('GET', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/accounts/account_id/r2/buckets/my-bucket', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldUpdateBucketStorageClass()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode([
                'success' => true,
                'result' => [
                    'name' => 'my-bucket',
                    'storageClass' => 'InfrequentAccess',
                ],
            ])),
        ]);

        $response = $client->accounts()->r2Buckets()->update('account_id', 'my-bucket', 'InfrequentAccess');

        $this->assertTrue($response->successful());
        $this->assertSame('InfrequentAccess', $response->json('result.storageClass'));

        $this->assertSame('PATCH', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/accounts/account_id/r2/buckets/my-bucket', $this->lastRequest()->getUri()->getPath());
        $this->assertSame('InfrequentAccess', $this->lastRequest()->getHeaderLine('cf-r2-storage-class'));
    }

    #[Test]
    public function shouldDeleteBucket()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode([
                'success' => true,
                'result' => null,
            ])),
        ]);

        $response = $client->accounts()->r2Buckets()->delete('account_id', 'my-bucket');

        $this->assertTrue($response->successful());

        $this->assertSame('DELETE', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/accounts/account_id/r2/buckets/my-bucket', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldDeleteBucketWithJurisdictionHeader()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode([
                'success' => true,
                'result' => null,
            ])),
        ]);

        $response = $client->accounts()->r2Buckets()->delete('account_id', 'my-bucket', 'eu');

        $this->assertTrue($response->successful());
        $this->assertSame('eu', $this->lastRequest()->getHeaderLine('cf-r2-jurisdiction'));
    }

    #[Test]
    public function shouldCreateTemporaryCredentials()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode([
                'success' => true,
                'result' => [
                    'accessKeyId' => 'access_key_id',
                ],
            ])),
        ]);

        $response = $client->accounts()->r2Buckets()->createTemporaryCredentials('account_id', [
            'bucket' => 'my-bucket',
            'permission' => 'object-read-only',
            'ttlSeconds' => 3600,
            'parentAccessKeyId' => 'parent_access_key_id',
        ]);

        $this->assertTrue($response->successful());
        $this->assertSame('access_key_id', $response->json('result.accessKeyId'));

        $this->assertSame('POST', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/accounts/account_id/r2/temp-access-credentials', $this->lastRequest()->getUri()->getPath());
    }
}
