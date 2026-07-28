<?php

namespace Cloudflare\Tests\Endpoints\Accounts;

use Cloudflare\Tests\Concerns\InteractsWithMockClient;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\Test;

class R2CustomDomainsTest extends TestCase
{
    use InteractsWithMockClient;

    #[Test]
    public function shouldListCustomDomains()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode([
                'success' => true,
                'result' => [
                    'domains' => [
                        ['domain' => 'assets.example.com'],
                    ],
                ],
            ])),
        ]);

        $response = $client->accounts()->r2CustomDomains()->list('account_id', 'my-bucket');

        $this->assertTrue($response->successful());
        $this->assertSame('assets.example.com', $response->json('result.domains.0.domain'));

        $this->assertSame('GET', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/accounts/account_id/r2/buckets/my-bucket/domains/custom', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldCreateCustomDomain()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode([
                'success' => true,
                'result' => [
                    'domain' => 'assets.example.com',
                ],
            ])),
        ]);

        $response = $client->accounts()->r2CustomDomains()->create('account_id', 'my-bucket', [
            'domain' => 'assets.example.com',
            'zoneId' => 'zone_id',
            'enabled' => true,
        ]);

        $this->assertTrue($response->successful());
        $this->assertSame('assets.example.com', $response->json('result.domain'));

        $this->assertSame('POST', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/accounts/account_id/r2/buckets/my-bucket/domains/custom', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldGetCustomDomainDetails()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode([
                'success' => true,
                'result' => [
                    'domain' => 'assets.example.com',
                ],
            ])),
        ]);

        $response = $client->accounts()->r2CustomDomains()->details('account_id', 'my-bucket', 'assets.example.com');

        $this->assertTrue($response->successful());
        $this->assertSame('assets.example.com', $response->json('result.domain'));

        $this->assertSame('GET', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/accounts/account_id/r2/buckets/my-bucket/domains/custom/assets.example.com', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldUpdateCustomDomain()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode([
                'success' => true,
                'result' => [
                    'domain' => 'assets.example.com',
                    'enabled' => false,
                ],
            ])),
        ]);

        $response = $client->accounts()->r2CustomDomains()->update('account_id', 'my-bucket', 'assets.example.com', [
            'enabled' => false,
        ]);

        $this->assertTrue($response->successful());
        $this->assertFalse($response->json('result.enabled'));

        $this->assertSame('PUT', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/accounts/account_id/r2/buckets/my-bucket/domains/custom/assets.example.com', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldDeleteCustomDomain()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode([
                'success' => true,
                'result' => null,
            ])),
        ]);

        $response = $client->accounts()->r2CustomDomains()->delete('account_id', 'my-bucket', 'assets.example.com');

        $this->assertTrue($response->successful());

        $this->assertSame('DELETE', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/accounts/account_id/r2/buckets/my-bucket/domains/custom/assets.example.com', $this->lastRequest()->getUri()->getPath());
    }
}
