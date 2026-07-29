<?php

namespace Cloudflare\Tests\Endpoints\Tenants;

use Cloudflare\Tests\Concerns\InteractsWithMockClient;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class MembershipsTest extends TestCase
{
    use InteractsWithMockClient;

    #[Test]
    public function shouldList()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => [['user_tag' => 'user_id']]])),
        ]);

        $response = $client->tenants()->memberships()->list('tenant_id');

        $this->assertTrue($response->successful());
        $this->assertSame('GET', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/tenants/tenant_id/memberships', $this->lastRequest()->getUri()->getPath());
    }
}
