<?php

namespace Cloudflare\Tests\Endpoints\Workers;

use Cloudflare\Exceptions\BadMethodCallException;
use Cloudflare\Tests\Concerns\InteractsWithMockClient;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class VersionsTest extends TestCase
{
    use InteractsWithMockClient;

    #[Test]
    public function shouldList()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => [['id' => 'version_id']]])),
        ]);

        $response = $client->workers()->versions()->list('account_id', 'script_name');

        $this->assertTrue($response->successful());
        $this->assertSame('GET', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/accounts/account_id/workers/scripts/script_name/versions', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldThrowOnUpload()
    {
        $client = $this->mockClient([]);

        $this->expectException(BadMethodCallException::class);

        $client->workers()->versions()->upload('account_id', 'script_name');
    }

    #[Test]
    public function shouldGetDetails()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => ['id' => 'version_id']])),
        ]);

        $response = $client->workers()->versions()->details('account_id', 'script_name', 'version_id');

        $this->assertTrue($response->successful());
        $this->assertSame('GET', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/accounts/account_id/workers/scripts/script_name/versions/version_id', $this->lastRequest()->getUri()->getPath());
    }
}
