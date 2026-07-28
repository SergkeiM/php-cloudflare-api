<?php

namespace Cloudflare\Tests\Endpoints\Accounts;

use Cloudflare\Tests\Concerns\InteractsWithMockClient;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\Test;

class R2SippyTest extends TestCase
{
    use InteractsWithMockClient;

    #[Test]
    public function shouldGetSippyConfiguration()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode([
                'success' => true,
                'result' => [
                    'enabled' => true,
                ],
            ])),
        ]);

        $response = $client->accounts()->r2Sippy()->details('account_id', 'my-bucket');

        $this->assertTrue($response->successful());
        $this->assertTrue($response->json('result.enabled'));

        $this->assertSame('GET', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/accounts/account_id/r2/buckets/my-bucket/sippy', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldEnableSippy()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode([
                'success' => true,
                'result' => [
                    'enabled' => true,
                ],
            ])),
        ]);

        $response = $client->accounts()->r2Sippy()->update('account_id', 'my-bucket', [
            'source' => ['provider' => 'aws', 'bucket' => 'source-bucket'],
            'destination' => ['provider' => 'r2'],
        ]);

        $this->assertTrue($response->successful());
        $this->assertTrue($response->json('result.enabled'));

        $this->assertSame('PUT', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/accounts/account_id/r2/buckets/my-bucket/sippy', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldDisableSippy()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode([
                'success' => true,
                'result' => null,
            ])),
        ]);

        $response = $client->accounts()->r2Sippy()->delete('account_id', 'my-bucket');

        $this->assertTrue($response->successful());

        $this->assertSame('DELETE', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/accounts/account_id/r2/buckets/my-bucket/sippy', $this->lastRequest()->getUri()->getPath());
    }
}
