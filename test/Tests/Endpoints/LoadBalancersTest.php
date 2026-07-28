<?php

namespace Cloudflare\Tests\Endpoints;

use Cloudflare\Tests\Concerns\InteractsWithMockClient;
use Cloudflare\Exceptions\InvalidArgumentException;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\Test;

class LoadBalancersTest extends TestCase
{
    use InteractsWithMockClient;

    #[Test]
    public function shouldListLoadBalancersForAccount()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode([
                'success' => true,
                'result' => [
                    ['id' => 'load_balancer_id'],
                ],
            ])),
        ]);

        $response = $client->loadBalancers()->list(accountId: 'account_id');

        $this->assertTrue($response->successful());
        $this->assertSame('load_balancer_id', $response->json('result.0.id'));

        $this->assertSame('GET', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/accounts/account_id/load_balancers', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldListLoadBalancersForZone()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode([
                'success' => true,
                'result' => [
                    ['id' => 'load_balancer_id'],
                ],
            ])),
        ]);

        $response = $client->loadBalancers()->list(zoneId: 'zone_id');

        $this->assertTrue($response->successful());

        $this->assertSame('GET', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/zones/zone_id/load_balancers', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldThrowWhenNeitherScopeProvided()
    {
        $client = $this->mockClient([]);

        $this->expectException(InvalidArgumentException::class);

        $client->loadBalancers()->list();
    }

    #[Test]
    public function shouldThrowWhenBothScopesProvided()
    {
        $client = $this->mockClient([]);

        $this->expectException(InvalidArgumentException::class);

        $client->loadBalancers()->list(accountId: 'account_id', zoneId: 'zone_id');
    }

    #[Test]
    public function shouldCreateLoadBalancerForZone()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode([
                'success' => true,
                'result' => [
                    'id' => 'load_balancer_id',
                ],
            ])),
        ]);

        $response = $client->loadBalancers()->create(null, 'zone_id', [
            'name' => 'www.example.com',
            'default_pools' => ['pool_id'],
            'fallback_pool' => 'pool_id',
        ]);

        $this->assertTrue($response->successful());
        $this->assertSame('load_balancer_id', $response->json('result.id'));

        $this->assertSame('POST', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/zones/zone_id/load_balancers', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldGetLoadBalancerDetailsForAccount()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode([
                'success' => true,
                'result' => [
                    'id' => 'load_balancer_id',
                ],
            ])),
        ]);

        $response = $client->loadBalancers()->get('account_id', null, 'load_balancer_id');

        $this->assertTrue($response->successful());
        $this->assertSame('load_balancer_id', $response->json('result.id'));

        $this->assertSame('GET', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/accounts/account_id/load_balancers/load_balancer_id', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldUpdateLoadBalancerForZone()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode([
                'success' => true,
                'result' => [
                    'id' => 'load_balancer_id',
                    'enabled' => false,
                ],
            ])),
        ]);

        $response = $client->loadBalancers()->update(null, 'zone_id', 'load_balancer_id', [
            'name' => 'www.example.com',
            'default_pools' => ['pool_id'],
            'fallback_pool' => 'pool_id',
            'enabled' => false,
        ]);

        $this->assertTrue($response->successful());
        $this->assertFalse($response->json('result.enabled'));

        $this->assertSame('PUT', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/zones/zone_id/load_balancers/load_balancer_id', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldEditLoadBalancerForAccount()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode([
                'success' => true,
                'result' => [
                    'id' => 'load_balancer_id',
                    'enabled' => false,
                ],
            ])),
        ]);

        $response = $client->loadBalancers()->edit('account_id', null, 'load_balancer_id', [
            'enabled' => false,
        ]);

        $this->assertTrue($response->successful());
        $this->assertFalse($response->json('result.enabled'));

        $this->assertSame('PATCH', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/accounts/account_id/load_balancers/load_balancer_id', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldDeleteLoadBalancerForZone()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode([
                'success' => true,
                'result' => [
                    'id' => 'load_balancer_id',
                ],
            ])),
        ]);

        $response = $client->loadBalancers()->delete(null, 'zone_id', 'load_balancer_id');

        $this->assertTrue($response->successful());

        $this->assertSame('DELETE', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/zones/zone_id/load_balancers/load_balancer_id', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldGetLoadBalancerUsage()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode([
                'success' => true,
                'result' => [
                    'load_balancers' => 1,
                ],
            ])),
        ]);

        $response = $client->loadBalancers()->usage('account_id');

        $this->assertTrue($response->successful());
        $this->assertSame(1, $response->json('result.load_balancers'));

        $this->assertSame('GET', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/accounts/account_id/load_balancers/usage', $this->lastRequest()->getUri()->getPath());
    }
}
