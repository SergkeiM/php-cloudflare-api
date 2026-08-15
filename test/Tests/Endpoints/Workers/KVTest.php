<?php

namespace Cloudflare\Tests\Endpoints\Workers;

use Cloudflare\Exceptions\MissingArgumentException;
use Cloudflare\Tests\Concerns\InteractsWithMockClient;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class KVTest extends TestCase
{
    use InteractsWithMockClient;

    #[Test]
    public function shouldList()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => [['id' => 'namespace_id']]])),
        ]);

        $response = $client->workers()->kv()->list('account_id');

        $this->assertTrue($response->successful());
        $this->assertSame('GET', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/accounts/account_id/storage/kv/namespaces', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldCreate()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => ['id' => 'namespace_id']])),
        ]);

        $response = $client->workers()->kv()->create('account_id', 'my-namespace');

        $this->assertTrue($response->successful());
        $this->assertSame('POST', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/accounts/account_id/storage/kv/namespaces', $this->lastRequest()->getUri()->getPath());
        $this->assertSame(['title' => 'my-namespace'], json_decode((string) $this->lastRequest()->getBody(), true));
    }

    #[Test]
    public function shouldGetDetails()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => ['id' => 'namespace_id']])),
        ]);

        $response = $client->workers()->kv()->get('account_id', 'namespace_id');

        $this->assertTrue($response->successful());
        $this->assertSame('GET', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/accounts/account_id/storage/kv/namespaces/namespace_id', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldUpdate()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => ['id' => 'namespace_id']])),
        ]);

        $response = $client->workers()->kv()->update('account_id', 'namespace_id', 'renamed');

        $this->assertTrue($response->successful());
        $this->assertSame('PUT', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/accounts/account_id/storage/kv/namespaces/namespace_id', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldDelete()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => null])),
        ]);

        $response = $client->workers()->kv()->delete('account_id', 'namespace_id');

        $this->assertTrue($response->successful());
        $this->assertSame('DELETE', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/accounts/account_id/storage/kv/namespaces/namespace_id', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldListKeys()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => [['name' => 'key1']]])),
        ]);

        $response = $client->workers()->kv()->listKeys('account_id', 'namespace_id');

        $this->assertTrue($response->successful());
        $this->assertSame('GET', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/accounts/account_id/storage/kv/namespaces/namespace_id/keys', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldGetKeyMetadata()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => ['someKey' => 'someValue']])),
        ]);

        $response = $client->workers()->kv()->keyMetadata('account_id', 'namespace_id', 'key1');

        $this->assertTrue($response->successful());
        $this->assertSame('GET', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/accounts/account_id/storage/kv/namespaces/namespace_id/metadata/key1', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldGetKeyDetails()
    {
        $client = $this->mockClient([
            new Response(200, [], 'value1'),
        ]);

        $response = $client->workers()->kv()->keyDetails('account_id', 'namespace_id', 'key1');

        $this->assertTrue($response->successful());
        $this->assertSame('GET', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/accounts/account_id/storage/kv/namespaces/namespace_id/values/key1', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldWriteKeyWithMetadata()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => null])),
        ]);

        $response = $client->workers()->kv()->writeKeyWithMetadata('account_id', 'namespace_id', 'key1', ['value' => 'value1']);

        $this->assertTrue($response->successful());
        $this->assertSame('PUT', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/accounts/account_id/storage/kv/namespaces/namespace_id/values/key1', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldDeleteKey()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => null])),
        ]);

        $response = $client->workers()->kv()->deleteKey('account_id', 'namespace_id', 'key1');

        $this->assertTrue($response->successful());
        $this->assertSame('DELETE', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/accounts/account_id/storage/kv/namespaces/namespace_id/values/key1', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldWriteMultipleKeys()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => null])),
        ]);

        $response = $client->workers()->kv()->writeMultipleKeys('account_id', 'namespace_id', [
            ['key' => 'key1', 'value' => 'value1'],
        ]);

        $this->assertTrue($response->successful());
        $this->assertSame('PUT', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/accounts/account_id/storage/kv/namespaces/namespace_id/bulk', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldDeleteMultipleKeys()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode([
                'success' => true,
                'result' => null,
            ])),
        ]);

        $response = $client->workers()->kv()->deleteMultipleKeys('account_id', 'namespace_id', ['key1', 'key2']);

        $this->assertTrue($response->successful());

        $this->assertSame('POST', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/accounts/account_id/storage/kv/namespaces/namespace_id/bulk/delete', $this->lastRequest()->getUri()->getPath());
        $this->assertSame(['key1', 'key2'], json_decode((string) $this->lastRequest()->getBody(), true));
    }

    #[Test]
    public function shouldGetMultipleKeys()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode([
                'success' => true,
                'result' => [
                    'values' => ['key1' => 'value1', 'key2' => 'value2'],
                ],
            ])),
        ]);

        $response = $client->workers()->kv()->getMultipleKeys('account_id', 'namespace_id', ['key1', 'key2']);

        $this->assertTrue($response->successful());
        $this->assertSame('value1', $response->json('result.values.key1'));

        $this->assertSame('POST', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/accounts/account_id/storage/kv/namespaces/namespace_id/bulk/get', $this->lastRequest()->getUri()->getPath());
        $this->assertSame([
            'keys' => ['key1', 'key2'],
            'type' => 'text',
            'withMetadata' => false,
        ], json_decode((string) $this->lastRequest()->getBody(), true));
    }

    #[Test]
    public function shouldGetMultipleKeysAsParsedJsonWithMetadata()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode([
                'success' => true,
                'result' => [
                    'values' => [
                        'key1' => ['value' => ['nested' => true], 'metadata' => ['owner' => 'ops']],
                    ],
                ],
            ])),
        ]);

        $response = $client->workers()->kv()->getMultipleKeys('account_id', 'namespace_id', ['key1'], 'json', true);

        $this->assertTrue($response->successful());
        $this->assertTrue($response->json('result.values.key1.value.nested'));

        $this->assertSame([
            'keys' => ['key1'],
            'type' => 'json',
            'withMetadata' => true,
        ], json_decode((string) $this->lastRequest()->getBody(), true));
    }

    /**
     * `keys` has to reach Cloudflare as a JSON array, so a caller's gappy list
     * is re-indexed rather than encoded as an object.
     */
    #[Test]
    public function shouldSendNonSequentialKeysAsAJsonArray()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => []])),
        ]);

        $client->workers()->kv()->getMultipleKeys('account_id', 'namespace_id', [2 => 'key1', 5 => 'key2']);

        $this->assertSame(['key1', 'key2'], json_decode((string) $this->lastRequest()->getBody(), true)['keys']);
    }

    #[Test]
    public function shouldThrowWhenNoKeysGiven()
    {
        $client = $this->mockClient([]);

        $this->expectException(MissingArgumentException::class);

        $client->workers()->kv()->getMultipleKeys('account_id', 'namespace_id', []);
    }
}
