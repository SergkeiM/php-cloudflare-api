<?php

namespace Cloudflare\Tests\Endpoints\Organizations;

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

        $response = $client->organizations()->members()->list('organization_id');

        $this->assertTrue($response->successful());
        $this->assertSame('GET', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/organizations/organization_id/members', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldCreate()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => ['id' => 'member_id']])),
        ]);

        $response = $client->organizations()->members()->create('organization_id', [
            'member' => ['user' => ['email' => 'user@example.com']],
        ]);

        $this->assertTrue($response->successful());
        $this->assertSame('POST', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/organizations/organization_id/members', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldThrowExceptionWhenCreateParamsAreMissing()
    {
        $client = $this->mockClient([]);

        $this->expectException(\Cloudflare\Exceptions\MissingArgumentException::class);

        $client->organizations()->members()->create('organization_id', []);
    }

    #[Test]
    public function shouldBatchCreate()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => [['id' => 'member_id']]])),
        ]);

        $response = $client->organizations()->members()->batchCreate('organization_id', [
            'members' => [['user' => ['email' => 'user@example.com']]],
        ]);

        $this->assertTrue($response->successful());
        $this->assertSame('POST', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/organizations/organization_id/members:batchCreate', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldThrowExceptionWhenBatchCreateParamsAreMissing()
    {
        $client = $this->mockClient([]);

        $this->expectException(\Cloudflare\Exceptions\MissingArgumentException::class);

        $client->organizations()->members()->batchCreate('organization_id', []);
    }

    #[Test]
    public function shouldGetDetails()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => ['id' => 'member_id']])),
        ]);

        $response = $client->organizations()->members()->get('organization_id', 'member_id');

        $this->assertTrue($response->successful());
        $this->assertSame('GET', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/organizations/organization_id/members/member_id', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldDelete()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => ['id' => 'member_id']])),
        ]);

        $response = $client->organizations()->members()->delete('organization_id', 'member_id');

        $this->assertTrue($response->successful());
        $this->assertSame('DELETE', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/organizations/organization_id/members/member_id', $this->lastRequest()->getUri()->getPath());
        $this->assertSame(['member_id' => 'member_id'], json_decode((string) $this->lastRequest()->getBody(), true));
    }
}
