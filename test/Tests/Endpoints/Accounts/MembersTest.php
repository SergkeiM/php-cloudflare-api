<?php

namespace Cloudflare\Tests\Endpoints\Accounts;

use Cloudflare\Tests\Concerns\InteractsWithMockClient;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class MembersTest extends TestCase
{
    use InteractsWithMockClient;

    #[Test]
    public function shouldList()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => [['id' => 'member_id']]])),
        ]);

        $response = $client->accounts()->members()->list('account_id');

        $this->assertTrue($response->successful());
        $this->assertSame('GET', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/accounts/account_id/members', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldAdd()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => ['id' => 'member_id']])),
        ]);

        $response = $client->accounts()->members()->add('account_id', [
            'email' => 'user@example.com',
            'roles' => ['role_id'],
        ]);

        $this->assertTrue($response->successful());
        $this->assertSame('POST', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/accounts/account_id/members', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldDelete()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => ['id' => 'member_id']])),
        ]);

        $response = $client->accounts()->members()->delete('account_id', 'member_id');

        $this->assertTrue($response->successful());
        $this->assertSame('DELETE', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/accounts/account_id/members/member_id', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldGetDetails()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => ['id' => 'member_id']])),
        ]);

        $response = $client->accounts()->members()->details('account_id', 'member_id');

        $this->assertTrue($response->successful());
        $this->assertSame('GET', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/accounts/account_id/members/member_id', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldUpdateRoles()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => ['id' => 'member_id']])),
        ]);

        $response = $client->accounts()->members()->updateRoles('account_id', 'member_id', ['role_id']);

        $this->assertTrue($response->successful());
        $this->assertSame('PUT', $this->lastRequest()->getMethod());
        $this->assertSame(['roles' => ['role_id']], json_decode((string) $this->lastRequest()->getBody(), true));
    }

    #[Test]
    public function shouldUpdatePolicies()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => ['id' => 'member_id']])),
        ]);

        $response = $client->accounts()->members()->updatePolicies('account_id', 'member_id', ['policy_id']);

        $this->assertTrue($response->successful());
        $this->assertSame('PUT', $this->lastRequest()->getMethod());
        $this->assertSame(['policies' => ['policy_id']], json_decode((string) $this->lastRequest()->getBody(), true));
    }
}
