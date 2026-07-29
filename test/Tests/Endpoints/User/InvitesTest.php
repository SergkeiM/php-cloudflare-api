<?php

namespace Cloudflare\Tests\Endpoints\User;

use Cloudflare\Tests\Concerns\InteractsWithMockClient;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class InvitesTest extends TestCase
{
    use InteractsWithMockClient;

    #[Test]
    public function shouldList()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => [['id' => 'invite_id']]])),
        ]);

        $response = $client->user()->invites()->list();

        $this->assertTrue($response->successful());
        $this->assertSame('GET', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/user/invites', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldGetDetails()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => ['id' => 'invite_id']])),
        ]);

        $response = $client->user()->invites()->get('invite_id');

        $this->assertTrue($response->successful());
        $this->assertSame('GET', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/user/invites/invite_id', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldRespond()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => ['id' => 'invite_id']])),
        ]);

        $response = $client->user()->invites()->respond('invite_id', 'accepted');

        $this->assertTrue($response->successful());
        $this->assertSame('PATCH', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/user/invites/invite_id', $this->lastRequest()->getUri()->getPath());
        $this->assertSame(['status' => 'accepted'], json_decode((string) $this->lastRequest()->getBody(), true));
    }
}
