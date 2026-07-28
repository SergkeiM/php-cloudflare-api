<?php

namespace Cloudflare\Tests\Endpoints\R2;

use Cloudflare\Tests\Concerns\InteractsWithMockClient;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\Test;

class CorsTest extends TestCase
{
    use InteractsWithMockClient;

    #[Test]
    public function shouldGetCorsConfiguration()
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

        $response = $client->r2()->cors()->get('account_id', 'my-bucket');

        $this->assertTrue($response->successful());
        $this->assertSame('rule-1', $response->json('result.rules.0.id'));

        $this->assertSame('GET', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/accounts/account_id/r2/buckets/my-bucket/cors', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldUpdateCorsConfiguration()
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

        $response = $client->r2()->cors()->update('account_id', 'my-bucket', [
            ['id' => 'rule-1', 'allowed' => ['methods' => ['GET'], 'origins' => ['*']]],
        ]);

        $this->assertTrue($response->successful());
        $this->assertSame('rule-1', $response->json('result.rules.0.id'));

        $this->assertSame('PUT', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/accounts/account_id/r2/buckets/my-bucket/cors', $this->lastRequest()->getUri()->getPath());
        $this->assertArrayHasKey('rules', json_decode((string) $this->lastRequest()->getBody(), true));
    }

    #[Test]
    public function shouldDeleteCorsConfiguration()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode([
                'success' => true,
                'result' => null,
            ])),
        ]);

        $response = $client->r2()->cors()->delete('account_id', 'my-bucket');

        $this->assertTrue($response->successful());

        $this->assertSame('DELETE', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/accounts/account_id/r2/buckets/my-bucket/cors', $this->lastRequest()->getUri()->getPath());
    }
}
