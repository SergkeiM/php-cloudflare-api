<?php

namespace Cloudflare\Tests\Endpoints;

use Cloudflare\Tests\Concerns\InteractsWithMockClient;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class AccountsTest extends TestCase
{
    use InteractsWithMockClient;

    #[Test]
    public function shouldList()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => [['id' => 'account_id']]])),
        ]);

        $response = $client->accounts()->list();

        $this->assertTrue($response->successful());
        $this->assertSame('GET', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/accounts', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldCreateWithoutUnit()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => ['id' => 'account_id']])),
        ]);

        $response = $client->accounts()->create('my account', 'standard');

        $this->assertTrue($response->successful());
        $this->assertSame('POST', $this->lastRequest()->getMethod());
        $this->assertSame([
            'name' => 'my account',
            'type' => 'standard',
        ], json_decode((string) $this->lastRequest()->getBody(), true));
    }

    #[Test]
    public function shouldCreateWithUnit()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => ['id' => 'account_id']])),
        ]);

        $response = $client->accounts()->create('my account', 'enterprise', 'unit_id');

        $this->assertTrue($response->successful());
        $this->assertSame([
            'name' => 'my account',
            'type' => 'enterprise',
            'unit' => ['id' => 'unit_id'],
        ], json_decode((string) $this->lastRequest()->getBody(), true));
    }

    #[Test]
    public function shouldGetDetails()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => ['id' => 'account_id']])),
        ]);

        $response = $client->accounts()->get('account_id');

        $this->assertTrue($response->successful());
        $this->assertSame('GET', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/accounts/account_id', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldUpdateWithoutSettings()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => ['id' => 'account_id']])),
        ]);

        $response = $client->accounts()->update('account_id', 'renamed account');

        $this->assertTrue($response->successful());
        $this->assertSame('PUT', $this->lastRequest()->getMethod());
        $this->assertSame(['name' => 'renamed account'], json_decode((string) $this->lastRequest()->getBody(), true));
    }

    #[Test]
    public function shouldUpdateWithSettings()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => ['id' => 'account_id']])),
        ]);

        $response = $client->accounts()->update('account_id', 'renamed account', ['enforce_twofactor' => true]);

        $this->assertTrue($response->successful());
        $this->assertSame([
            'name' => 'renamed account',
            'settings' => ['enforce_twofactor' => true],
        ], json_decode((string) $this->lastRequest()->getBody(), true));
    }

    #[Test]
    public function shouldDelete()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => ['id' => 'account_id']])),
        ]);

        $response = $client->accounts()->delete('account_id');

        $this->assertTrue($response->successful());
        $this->assertSame('DELETE', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/accounts/account_id', $this->lastRequest()->getUri()->getPath());
    }
}
