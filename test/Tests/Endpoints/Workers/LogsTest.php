<?php

namespace Cloudflare\Tests\Endpoints\Workers;

use Cloudflare\Tests\Concerns\InteractsWithMockClient;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class LogsTest extends TestCase
{
    use InteractsWithMockClient;

    #[Test]
    public function shouldGet()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => [['id' => 'tail_id']]])),
        ]);

        $response = $client->workers()->logs()->list('account_id', 'script_name');

        $this->assertTrue($response->successful());
        $this->assertSame('GET', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/accounts/account_id/workers/scripts/script_name/tails', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldStart()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => ['id' => 'tail_id']])),
        ]);

        $response = $client->workers()->logs()->start('account_id', 'script_name');

        $this->assertTrue($response->successful());
        $this->assertSame('POST', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/accounts/account_id/workers/scripts/script_name/tails', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldDelete()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => null])),
        ]);

        $response = $client->workers()->logs()->delete('account_id', 'script_name', 'tail_id');

        $this->assertTrue($response->successful());
        $this->assertSame('DELETE', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/accounts/account_id/workers/scripts/script_name/tails/tail_id', $this->lastRequest()->getUri()->getPath());
    }
}
