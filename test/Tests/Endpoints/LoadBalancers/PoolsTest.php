<?php

namespace Cloudflare\Tests\Endpoints\LoadBalancers;

use Cloudflare\Tests\Concerns\InteractsWithMockClient;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\Test;

class PoolsTest extends TestCase
{
    use InteractsWithMockClient;

    #[Test]
    public function shouldListPools()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode([
                'success' => true,
                'result' => [
                    ['id' => 'pool_id'],
                ],
            ])),
        ]);

        $response = $client->loadBalancers()->pools()->list('account_id');

        $this->assertTrue($response->successful());
        $this->assertSame('pool_id', $response->json('result.0.id'));

        $this->assertSame('GET', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/accounts/account_id/load_balancers/pools', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldCreatePool()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode([
                'success' => true,
                'result' => [
                    'id' => 'pool_id',
                ],
            ])),
        ]);

        $response = $client->loadBalancers()->pools()->create('account_id', [
            'name' => 'primary-pool',
            'origins' => [
                ['name' => 'origin-1', 'address' => '192.0.2.1'],
            ],
        ]);

        $this->assertTrue($response->successful());
        $this->assertSame('pool_id', $response->json('result.id'));

        $this->assertSame('POST', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/accounts/account_id/load_balancers/pools', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldGetPoolDetails()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode([
                'success' => true,
                'result' => [
                    'id' => 'pool_id',
                ],
            ])),
        ]);

        $response = $client->loadBalancers()->pools()->get('account_id', 'pool_id');

        $this->assertTrue($response->successful());
        $this->assertSame('pool_id', $response->json('result.id'));

        $this->assertSame('GET', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/accounts/account_id/load_balancers/pools/pool_id', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldUpdatePool()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode([
                'success' => true,
                'result' => [
                    'id' => 'pool_id',
                    'enabled' => false,
                ],
            ])),
        ]);

        $response = $client->loadBalancers()->pools()->update('account_id', 'pool_id', [
            'name' => 'primary-pool',
            'origins' => [
                ['name' => 'origin-1', 'address' => '192.0.2.1'],
            ],
            'enabled' => false,
        ]);

        $this->assertTrue($response->successful());
        $this->assertFalse($response->json('result.enabled'));

        $this->assertSame('PUT', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/accounts/account_id/load_balancers/pools/pool_id', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldEditPool()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode([
                'success' => true,
                'result' => [
                    'id' => 'pool_id',
                    'enabled' => false,
                ],
            ])),
        ]);

        $response = $client->loadBalancers()->pools()->edit('account_id', 'pool_id', [
            'enabled' => false,
        ]);

        $this->assertTrue($response->successful());
        $this->assertFalse($response->json('result.enabled'));

        $this->assertSame('PATCH', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/accounts/account_id/load_balancers/pools/pool_id', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldBulkEditPools()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode([
                'success' => true,
                'result' => [
                    ['id' => 'pool_id', 'enabled' => false],
                ],
            ])),
        ]);

        $response = $client->loadBalancers()->pools()->bulkEdit('account_id', [
            ['id' => 'pool_id', 'enabled' => false],
        ]);

        $this->assertTrue($response->successful());
        $this->assertFalse($response->json('result.0.enabled'));

        $this->assertSame('PATCH', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/accounts/account_id/load_balancers/pools', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldDeletePool()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode([
                'success' => true,
                'result' => [
                    'id' => 'pool_id',
                ],
            ])),
        ]);

        $response = $client->loadBalancers()->pools()->delete('account_id', 'pool_id');

        $this->assertTrue($response->successful());

        $this->assertSame('DELETE', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/accounts/account_id/load_balancers/pools/pool_id', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldGetPoolHealth()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode([
                'success' => true,
                'result' => [
                    'pool_id' => 'pool_id',
                    'healthy' => true,
                ],
            ])),
        ]);

        $response = $client->loadBalancers()->pools()->health('account_id', 'pool_id');

        $this->assertTrue($response->successful());
        $this->assertTrue($response->json('result.healthy'));

        $this->assertSame('GET', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/accounts/account_id/load_balancers/pools/pool_id/health', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldPreviewPool()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode([
                'success' => true,
                'result' => [
                    'preview_id' => 'preview_id',
                ],
            ])),
        ]);

        $response = $client->loadBalancers()->pools()->preview('account_id', 'pool_id', [
            'monitor' => 'monitor_id',
        ]);

        $this->assertTrue($response->successful());
        $this->assertSame('preview_id', $response->json('result.preview_id'));

        $this->assertSame('POST', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/accounts/account_id/load_balancers/pools/pool_id/preview', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldListPoolReferences()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode([
                'success' => true,
                'result' => [
                    ['reference_type' => 'referral', 'resource_id' => 'load_balancer_id'],
                ],
            ])),
        ]);

        $response = $client->loadBalancers()->pools()->references('account_id', 'pool_id');

        $this->assertTrue($response->successful());
        $this->assertSame('load_balancer_id', $response->json('result.0.resource_id'));

        $this->assertSame('GET', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/accounts/account_id/load_balancers/pools/pool_id/references', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldListFilteredByMonitor()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => []])),
        ]);

        $client->loadBalancers()->pools()->list('account_id', ['monitor' => 'monitor_id']);

        $this->assertSame('monitor=monitor_id', $this->lastRequest()->getUri()->getQuery());
    }
}
