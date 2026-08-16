<?php

namespace Cloudflare\Tests\Endpoints;

use Cloudflare\Tests\Concerns\InteractsWithMockClient;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    use InteractsWithMockClient;

    #[Test]
    public function shouldGetDetails()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => ['id' => 'user_id']])),
        ]);

        $response = $client->user()->get();

        $this->assertTrue($response->successful());
        $this->assertSame('GET', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/user', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldEdit()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => ['id' => 'user_id']])),
        ]);

        $response = $client->user()->edit(['first_name' => 'John']);

        $this->assertTrue($response->successful());
        $this->assertSame('PATCH', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/user', $this->lastRequest()->getUri()->getPath());
        $this->assertSame(['first_name' => 'John'], json_decode((string) $this->lastRequest()->getBody(), true));
    }
}
