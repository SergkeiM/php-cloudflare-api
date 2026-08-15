<?php

namespace Cloudflare\Tests\Endpoints;

use Cloudflare\Tests\Concerns\InteractsWithMockClient;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class DurableObjectsTest extends TestCase
{
    use InteractsWithMockClient;

    #[Test]
    public function shouldList()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode([
                'success' => true,
                'result' => [
                    ['id' => 'namespace_id'],
                ],
            ])),
        ]);

        $response = $client->durableObjects()->list('account_id');

        $this->assertTrue($response->successful());
        $this->assertSame('namespace_id', $response->json('result.0.id'));

        $this->assertSame('GET', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/accounts/account_id/workers/durable_objects/namespaces', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldListObjects()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode([
                'success' => true,
                'result' => [
                    ['id' => 'object_id'],
                ],
            ])),
        ]);

        $response = $client->durableObjects()->listObjects('account_id', 'namespace_id');

        $this->assertTrue($response->successful());
        $this->assertSame('object_id', $response->json('result.0.id'));

        $this->assertSame('GET', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/accounts/account_id/workers/durable_objects/namespaces/namespace_id/objects', $this->lastRequest()->getUri()->getPath());
    }
}
