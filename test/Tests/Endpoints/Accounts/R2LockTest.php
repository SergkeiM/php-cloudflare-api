<?php

namespace Cloudflare\Tests\Endpoints\Accounts;

use Cloudflare\Tests\Concerns\InteractsWithMockClient;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\Test;

class R2LockTest extends TestCase
{
    use InteractsWithMockClient;

    #[Test]
    public function shouldGetLockConfiguration()
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

        $response = $client->accounts()->r2Lock()->details('account_id', 'my-bucket');

        $this->assertTrue($response->successful());
        $this->assertSame('rule-1', $response->json('result.rules.0.id'));

        $this->assertSame('GET', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/accounts/account_id/r2/buckets/my-bucket/lock', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldUpdateLockConfiguration()
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

        $response = $client->accounts()->r2Lock()->update('account_id', 'my-bucket', [
            ['id' => 'rule-1', 'condition' => ['type' => 'Age', 'maxAgeSeconds' => 86400]],
        ]);

        $this->assertTrue($response->successful());
        $this->assertSame('rule-1', $response->json('result.rules.0.id'));

        $this->assertSame('PUT', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/accounts/account_id/r2/buckets/my-bucket/lock', $this->lastRequest()->getUri()->getPath());
    }
}
