<?php

namespace Cloudflare\Tests\Endpoints\R2;

use Cloudflare\Tests\Concerns\InteractsWithMockClient;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\Test;

class LifecycleTest extends TestCase
{
    use InteractsWithMockClient;

    #[Test]
    public function shouldGetLifecycleConfiguration()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode([
                'success' => true,
                'result' => [
                    'rules' => [
                        ['id' => 'rule-1'],
                    ],
                ],
            ])),
        ]);

        $response = $client->r2()->lifecycle()->get('account_id', 'my-bucket');

        $this->assertTrue($response->successful());
        $this->assertSame('rule-1', $response->json('result.rules.0.id'));

        $this->assertSame('GET', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/accounts/account_id/r2/buckets/my-bucket/lifecycle', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldUpdateLifecycleConfiguration()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode([
                'success' => true,
                'result' => [
                    'rules' => [
                        ['id' => 'rule-1'],
                    ],
                ],
            ])),
        ]);

        $response = $client->r2()->lifecycle()->update('account_id', 'my-bucket', [
            ['id' => 'rule-1', 'conditions' => ['maxAge' => 3600]],
        ]);

        $this->assertTrue($response->successful());
        $this->assertSame('rule-1', $response->json('result.rules.0.id'));

        $this->assertSame('PUT', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/accounts/account_id/r2/buckets/my-bucket/lifecycle', $this->lastRequest()->getUri()->getPath());
    }
}
