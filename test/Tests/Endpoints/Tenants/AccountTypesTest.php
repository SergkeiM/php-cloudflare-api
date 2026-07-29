<?php

namespace Cloudflare\Tests\Endpoints\Tenants;

use Cloudflare\Tests\Concerns\InteractsWithMockClient;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class AccountTypesTest extends TestCase
{
    use InteractsWithMockClient;

    #[Test]
    public function shouldList()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => ['standard']])),
        ]);

        $response = $client->tenants()->accountTypes()->list('tenant_id');

        $this->assertTrue($response->successful());
        $this->assertSame('GET', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/tenants/tenant_id/account_types', $this->lastRequest()->getUri()->getPath());
    }
}
