<?php

namespace Cloudflare\Tests;

use Cloudflare\Tests\Concerns\InteractsWithMockClient;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class IPTest extends TestCase
{
    use InteractsWithMockClient;

    #[Test]
    public function shouldGet()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => ['ipv4_cidrs' => []]])),
        ]);

        $response = $client->ips()->get();

        $this->assertTrue($response->successful());
        $this->assertSame('GET', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/ips', $this->lastRequest()->getUri()->getPath());
    }
}
