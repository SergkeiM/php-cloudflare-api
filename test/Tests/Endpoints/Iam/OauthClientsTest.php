<?php

namespace Cloudflare\Tests\Endpoints\Iam;

use Cloudflare\Tests\Concerns\InteractsWithMockClient;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class OauthClientsTest extends TestCase
{
    use InteractsWithMockClient;

    private function validValues(): array
    {
        return [
            'client_name' => 'My OAuth App',
            'grant_types' => ['authorization_code'],
            'redirect_uris' => ['https://example.com/callback'],
            'response_types' => ['code'],
            'scopes' => ['account:read'],
            'token_endpoint_auth_method' => 'client_secret_post',
        ];
    }

    #[Test]
    public function shouldList()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => [['id' => 'oauth_client_id']]])),
        ]);

        $response = $client->iam()->oauthClients()->list('account_id');

        $this->assertTrue($response->successful());
        $this->assertSame('GET', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/accounts/account_id/oauth_clients', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldCreate()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => ['id' => 'oauth_client_id']])),
        ]);

        $response = $client->iam()->oauthClients()->create('account_id', $this->validValues());

        $this->assertTrue($response->successful());
        $this->assertSame('POST', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/accounts/account_id/oauth_clients', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldThrowExceptionWhenCreateParamsAreMissing()
    {
        $client = $this->mockClient([]);

        $this->expectException(\Cloudflare\Exceptions\MissingArgumentException::class);

        $client->iam()->oauthClients()->create('account_id', ['client_name' => 'My OAuth App']);
    }

    #[Test]
    public function shouldGetDetails()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => ['id' => 'oauth_client_id']])),
        ]);

        $response = $client->iam()->oauthClients()->get('account_id', 'oauth_client_id');

        $this->assertTrue($response->successful());
        $this->assertSame('GET', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/accounts/account_id/oauth_clients/oauth_client_id', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldEdit()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => ['id' => 'oauth_client_id']])),
        ]);

        $response = $client->iam()->oauthClients()->edit('account_id', 'oauth_client_id', ['client_name' => 'Renamed App']);

        $this->assertTrue($response->successful());
        $this->assertSame('PATCH', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/accounts/account_id/oauth_clients/oauth_client_id', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldDelete()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => ['id' => 'oauth_client_id']])),
        ]);

        $response = $client->iam()->oauthClients()->delete('account_id', 'oauth_client_id');

        $this->assertTrue($response->successful());
        $this->assertSame('DELETE', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/accounts/account_id/oauth_clients/oauth_client_id', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldRotateSecret()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => ['id' => 'oauth_client_id']])),
        ]);

        $response = $client->iam()->oauthClients()->rotateSecret('account_id', 'oauth_client_id');

        $this->assertTrue($response->successful());
        $this->assertSame('POST', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/accounts/account_id/oauth_clients/oauth_client_id/rotate_secret', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldDeleteRotatedSecret()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => ['id' => 'oauth_client_id']])),
        ]);

        $response = $client->iam()->oauthClients()->deleteRotatedSecret('account_id', 'oauth_client_id');

        $this->assertTrue($response->successful());
        $this->assertSame('DELETE', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/accounts/account_id/oauth_clients/oauth_client_id/rotate_secret', $this->lastRequest()->getUri()->getPath());
    }
}
