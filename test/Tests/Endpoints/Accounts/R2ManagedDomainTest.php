<?php

namespace Cloudflare\Tests\Endpoints\Accounts;

use Cloudflare\Tests\Concerns\InteractsWithMockClient;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\Test;

class R2ManagedDomainTest extends TestCase
{
    use InteractsWithMockClient;

    #[Test]
    public function shouldGetManagedDomainDetails()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode([
                'success' => true,
                'result' => [
                    'enabled' => true,
                ],
            ])),
        ]);

        $response = $client->accounts()->r2ManagedDomain()->details('account_id', 'my-bucket');

        $this->assertTrue($response->successful());
        $this->assertTrue($response->json('result.enabled'));

        $this->assertSame('GET', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/accounts/account_id/r2/buckets/my-bucket/domains/managed', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldUpdateManagedDomain()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode([
                'success' => true,
                'result' => [
                    'enabled' => false,
                ],
            ])),
        ]);

        $response = $client->accounts()->r2ManagedDomain()->update('account_id', 'my-bucket', false);

        $this->assertTrue($response->successful());
        $this->assertFalse($response->json('result.enabled'));

        $this->assertSame('PUT', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/accounts/account_id/r2/buckets/my-bucket/domains/managed', $this->lastRequest()->getUri()->getPath());
        $this->assertSame(['enabled' => false], json_decode((string) $this->lastRequest()->getBody(), true));
    }
}
