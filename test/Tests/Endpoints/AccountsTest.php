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

        $response = $client->accounts()->create(['name' => 'my account', 'type' => 'standard']);

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

        $response = $client->accounts()->create(['name' => 'my account', 'type' => 'enterprise', 'unit' => ['id' => 'unit_id']]);

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

        $response = $client->accounts()->update('account_id', ['name' => 'renamed account']);

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

        $response = $client->accounts()->update('account_id', ['name' => 'renamed account', 'settings' => ['enforce_twofactor' => true]]);

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

    #[Test]
    public function shouldGetProfile()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => ['id' => 'account_id']])),
        ]);

        $response = $client->accounts()->profile('account_id');

        $this->assertTrue($response->successful());
        $this->assertSame('GET', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/accounts/account_id/profile', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldUpdateProfile()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => ['id' => 'account_id']])),
        ]);

        $response = $client->accounts()->updateProfile('account_id', ['name' => 'renamed']);

        $this->assertTrue($response->successful());
        $this->assertSame('PUT', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/accounts/account_id/profile', $this->lastRequest()->getUri()->getPath());
        $this->assertSame(['name' => 'renamed'], json_decode((string) $this->lastRequest()->getBody(), true));
    }

    #[Test]
    public function shouldListOrganizations()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => [['id' => 'organization_id']]])),
        ]);

        $response = $client->accounts()->organizations('account_id');

        $this->assertTrue($response->successful());
        $this->assertSame('GET', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/accounts/account_id/organizations', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldMove()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => [
                'account_id' => 'account_id',
                'destination_organization_id' => 'organization_id',
                'source_organization_id' => 'previous_organization_id',
            ]])),
        ]);

        $response = $client->accounts()->move('account_id', 'organization_id');

        $this->assertTrue($response->successful());
        $this->assertSame('POST', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/accounts/account_id/move', $this->lastRequest()->getUri()->getPath());
        $this->assertSame(
            ['destination_organization_id' => 'organization_id'],
            json_decode((string) $this->lastRequest()->getBody(), true)
        );
    }
}
