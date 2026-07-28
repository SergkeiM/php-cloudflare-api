<?php

namespace Cloudflare\Tests\Endpoints\Workers;

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

        $response = $client->workers()->kv()->details('account_id', 'namespace_id');

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
}
