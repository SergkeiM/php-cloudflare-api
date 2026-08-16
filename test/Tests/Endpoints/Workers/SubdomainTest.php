<?php

namespace Cloudflare\Tests\Endpoints\Workers;

use Cloudflare\Tests\Concerns\InteractsWithMockClient;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class SubdomainTest extends TestCase
{
    use InteractsWithMockClient;

    #[Test]
    public function shouldGet()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => ['subdomain' => 'my-subdomain']])),
        ]);

        $response = $client->workers()->subdomain()->get('account_id');

        $this->assertTrue($response->successful());
        $this->assertSame('GET', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/accounts/account_id/workers/subdomain', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldUpdate()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => ['subdomain' => 'my-subdomain']])),
        ]);

        $response = $client->workers()->subdomain()->update('account_id', 'my-subdomain');

        $this->assertTrue($response->successful());
        $this->assertSame('PUT', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/accounts/account_id/workers/subdomain', $this->lastRequest()->getUri()->getPath());
        $this->assertSame(['subdomain' => 'my-subdomain'], json_decode((string) $this->lastRequest()->getBody(), true));
    }
}
