<?php

namespace Cloudflare\Tests\Endpoints\Accounts;

use Cloudflare\Tests\Concerns\InteractsWithMockClient;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class TokensTest extends TestCase
{
    use InteractsWithMockClient;

    #[Test]
    public function shouldList()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => [['id' => 'token_id']]])),
        ]);

        $response = $client->accounts()->tokens()->list('account_id');

        $this->assertTrue($response->successful());
        $this->assertSame('GET', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/accounts/account_id/tokens', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldCreate()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => ['id' => 'token_id']])),
        ]);

        $response = $client->accounts()->tokens()->create('account_id', [
            'name' => 'readonly token',
            'policies' => [['effect' => 'allow']],
        ]);

        $this->assertTrue($response->successful());
        $this->assertSame('POST', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/accounts/account_id/tokens', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldThrowExceptionWhenCreateParamsAreMissing()
    {
        $client = $this->mockClient([]);

        $this->expectException(\Cloudflare\Exceptions\MissingArgumentException::class);

        $client->accounts()->tokens()->create('account_id', ['name' => 'readonly token']);
    }

    #[Test]
    public function shouldGetDetails()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => ['id' => 'token_id']])),
        ]);

        $response = $client->accounts()->tokens()->get('account_id', 'token_id');

        $this->assertTrue($response->successful());
        $this->assertSame('GET', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/accounts/account_id/tokens/token_id', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldUpdate()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => ['id' => 'token_id']])),
        ]);

        $response = $client->accounts()->tokens()->update('account_id', 'token_id', [
            'name' => 'renamed token',
        ]);

        $this->assertTrue($response->successful());
        $this->assertSame('PUT', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/accounts/account_id/tokens/token_id', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldDelete()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => ['id' => 'token_id']])),
        ]);

        $response = $client->accounts()->tokens()->delete('account_id', 'token_id');

        $this->assertTrue($response->successful());
        $this->assertSame('DELETE', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/accounts/account_id/tokens/token_id', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldVerify()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => ['id' => 'token_id', 'status' => 'active']])),
        ]);

        $response = $client->accounts()->tokens()->verify('account_id');

        $this->assertTrue($response->successful());
        $this->assertSame('GET', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/accounts/account_id/tokens/verify', $this->lastRequest()->getUri()->getPath());
    }
}
