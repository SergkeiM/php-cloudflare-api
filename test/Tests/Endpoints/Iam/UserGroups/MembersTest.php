<?php

namespace Cloudflare\Tests\Endpoints\Iam\UserGroups;

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

        $response = $client->iam()->userGroups()->members()->list('account_id', 'user_group_id');

        $this->assertTrue($response->successful());
        $this->assertSame('GET', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/accounts/account_id/iam/user_groups/user_group_id/members', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldCreate()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => [['id' => 'member_id']]])),
        ]);

        $response = $client->iam()->userGroups()->members()->create('account_id', 'user_group_id', [
            ['id' => 'member_id'],
        ]);

        $this->assertTrue($response->successful());
        $this->assertSame('POST', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/accounts/account_id/iam/user_groups/user_group_id/members', $this->lastRequest()->getUri()->getPath());
        $this->assertSame([['id' => 'member_id']], json_decode((string) $this->lastRequest()->getBody(), true));
    }

    #[Test]
    public function shouldUpdate()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => [['id' => 'member_id']]])),
        ]);

        $response = $client->iam()->userGroups()->members()->update('account_id', 'user_group_id', [
            ['id' => 'member_id'],
        ]);

        $this->assertTrue($response->successful());
        $this->assertSame('PUT', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/accounts/account_id/iam/user_groups/user_group_id/members', $this->lastRequest()->getUri()->getPath());
        $this->assertSame([['id' => 'member_id']], json_decode((string) $this->lastRequest()->getBody(), true));
    }

    #[Test]
    public function shouldDelete()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => ['id' => 'member_id']])),
        ]);

        $response = $client->iam()->userGroups()->members()->delete('account_id', 'user_group_id', 'member_id');

        $this->assertTrue($response->successful());
        $this->assertSame('DELETE', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/accounts/account_id/iam/user_groups/user_group_id/members/member_id', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldGetDetails()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => ['id' => 'member_id']])),
        ]);

        $response = $client->iam()->userGroups()->members()->get('account_id', 'user_group_id', 'member_id');

        $this->assertTrue($response->successful());
        $this->assertSame('GET', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/accounts/account_id/iam/user_groups/user_group_id/members/member_id', $this->lastRequest()->getUri()->getPath());
    }
}
