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
