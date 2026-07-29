<?php

namespace Cloudflare\Tests\Endpoints\Iam;

use Cloudflare\Tests\Concerns\InteractsWithMockClient;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class OauthScopesTest extends TestCase
{
    use InteractsWithMockClient;

    #[Test]
    public function shouldList()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => [['scope' => 'account:read']]])),
        ]);

        $response = $client->iam()->oauthScopes()->list();

        $this->assertTrue($response->successful());
        $this->assertSame('GET', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/oauth/scopes', $this->lastRequest()->getUri()->getPath());
    }
}
