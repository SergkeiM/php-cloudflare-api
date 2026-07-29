<?php

namespace Cloudflare\Tests\Endpoints\Accounts\Tokens;

use Cloudflare\Tests\Concerns\InteractsWithMockClient;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class ValueTest extends TestCase
{
    use InteractsWithMockClient;

    #[Test]
    public function shouldRoll()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => ['value' => 'new_token_secret']])),
        ]);

        $response = $client->accounts()->tokens()->value()->roll('account_id', 'token_id');

        $this->assertTrue($response->successful());
        $this->assertSame('PUT', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/accounts/account_id/tokens/token_id/value', $this->lastRequest()->getUri()->getPath());
    }
}
