<?php

namespace Cloudflare\Tests\Endpoints\Tunnel;

use Cloudflare\Tests\Concerns\InteractsWithMockClient;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class VirtualNetworksTest extends TestCase
{
    use InteractsWithMockClient;

    #[Test]
    public function shouldList()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => [['id' => 'vnet_id']]])),
        ]);

        $response = $client->tunnel()->virtualNetworks()->list('account_id');

        $this->assertTrue($response->successful());
        $this->assertSame('GET', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/accounts/account_id/teamnet/virtual_networks', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldCreateWithoutComment()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => ['id' => 'vnet_id']])),
        ]);

        $response = $client->tunnel()->virtualNetworks()->create('account_id', 'my-network');

        $this->assertTrue($response->successful());
        $this->assertSame('POST', $this->lastRequest()->getMethod());
        $this->assertSame([
            'name' => 'my-network',
            'is_default' => false,
        ], json_decode((string) $this->lastRequest()->getBody(), true));
    }

    #[Test]
    public function shouldCreateWithComment()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => ['id' => 'vnet_id']])),
        ]);

        $response = $client->tunnel()->virtualNetworks()->create('account_id', 'my-network', true, 'my comment');

        $this->assertTrue($response->successful());
        $this->assertSame([
            'name' => 'my-network',
            'is_default' => true,
            'comment' => 'my comment',
        ], json_decode((string) $this->lastRequest()->getBody(), true));
    }

    #[Test]
    public function shouldGetDetails()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => ['id' => 'vnet_id']])),
        ]);

        $response = $client->tunnel()->virtualNetworks()->get('account_id', 'vnet_id');

        $this->assertTrue($response->successful());
        $this->assertSame('GET', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/accounts/account_id/teamnet/virtual_networks/vnet_id', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldUpdate()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => ['id' => 'vnet_id']])),
        ]);

        $response = $client->tunnel()->virtualNetworks()->edit('account_id', 'vnet_id', ['comment' => 'updated']);

        $this->assertTrue($response->successful());
        $this->assertSame('PATCH', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/accounts/account_id/teamnet/virtual_networks/vnet_id', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldDelete()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => null])),
        ]);

        $response = $client->tunnel()->virtualNetworks()->delete('account_id', 'vnet_id');

        $this->assertTrue($response->successful());
        $this->assertSame('DELETE', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/accounts/account_id/teamnet/virtual_networks/vnet_id', $this->lastRequest()->getUri()->getPath());
    }
}
