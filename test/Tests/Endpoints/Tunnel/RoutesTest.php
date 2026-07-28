<?php

namespace Cloudflare\Tests\Endpoints\Tunnel;

use Cloudflare\Tests\Concerns\InteractsWithMockClient;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class RoutesTest extends TestCase
{
    use InteractsWithMockClient;

    #[Test]
    public function shouldList()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => [['id' => 'route_id']]])),
        ]);

        $response = $client->tunnel()->routes()->list('account_id');

        $this->assertTrue($response->successful());
        $this->assertSame('GET', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/accounts/account_id/teamnet/routes', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldGetByIpWithoutVirtualNetwork()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => [['id' => 'route_id']]])),
        ]);

        $response = $client->tunnel()->routes()->getByIP('account_id', '127.0.0.1');

        $this->assertTrue($response->successful());
        $this->assertSame('GET', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/accounts/account_id/teamnet/routes/ip/127.0.0.1', $this->lastRequest()->getUri()->getPath());
        $this->assertSame('', $this->lastRequest()->getUri()->getQuery());
    }

    #[Test]
    public function shouldGetByIpWithVirtualNetwork()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => [['id' => 'route_id']]])),
        ]);

        $response = $client->tunnel()->routes()->getByIP('account_id', '127.0.0.1', 'vnet_id');

        $this->assertTrue($response->successful());
        $this->assertStringContainsString('virtual_network_id=vnet_id', $this->lastRequest()->getUri()->getQuery());
    }

    #[Test]
    public function shouldCreateWithoutOptionalParams()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => ['id' => 'route_id']])),
        ]);

        $response = $client->tunnel()->routes()->create('account_id', '10.0.0.0/24');

        $this->assertTrue($response->successful());
        $this->assertSame('POST', $this->lastRequest()->getMethod());
        $this->assertSame(['network' => '10.0.0.0/24'], json_decode((string) $this->lastRequest()->getBody(), true));
    }

    #[Test]
    public function shouldCreateWithOptionalParams()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => ['id' => 'route_id']])),
        ]);

        $response = $client->tunnel()->routes()->create('account_id', '10.0.0.0/24', 'vnet_id', 'my comment');

        $this->assertTrue($response->successful());
        $this->assertSame([
            'network' => '10.0.0.0/24',
            'virtual_network_id' => 'vnet_id',
            'comment' => 'my comment',
        ], json_decode((string) $this->lastRequest()->getBody(), true));
    }

    #[Test]
    public function shouldGetDetails()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => ['id' => 'route_id']])),
        ]);

        $response = $client->tunnel()->routes()->get('account_id', 'route_id');

        $this->assertTrue($response->successful());
        $this->assertSame('GET', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/accounts/account_id/teamnet/routes/route_id', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldUpdate()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => ['id' => 'route_id']])),
        ]);

        $response = $client->tunnel()->routes()->edit('account_id', 'route_id', ['comment' => 'updated']);

        $this->assertTrue($response->successful());
        $this->assertSame('PATCH', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/accounts/account_id/teamnet/routes/route_id', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldDelete()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => null])),
        ]);

        $response = $client->tunnel()->routes()->delete('account_id', 'route_id');

        $this->assertTrue($response->successful());
        $this->assertSame('DELETE', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/accounts/account_id/teamnet/routes/route_id', $this->lastRequest()->getUri()->getPath());
    }
}
