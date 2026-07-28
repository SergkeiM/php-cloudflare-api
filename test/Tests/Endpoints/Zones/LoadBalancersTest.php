<?php

namespace Cloudflare\Tests\Endpoints\Zones;

use Cloudflare\Tests\Concerns\InteractsWithMockClient;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\Test;

class LoadBalancersTest extends TestCase
{
    use InteractsWithMockClient;

    #[Test]
    public function shouldListLoadBalancers()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode([
                'success' => true,
                'result' => [
                    ['id' => 'load_balancer_id'],
                ],
            ])),
        ]);

        $response = $client->zones()->loadBalancers()->list('zone_id');

        $this->assertTrue($response->successful());
        $this->assertSame('load_balancer_id', $response->json('result.0.id'));

        $this->assertSame('GET', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/zones/zone_id/load_balancers', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldCreateLoadBalancer()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode([
                'success' => true,
                'result' => [
                    'id' => 'load_balancer_id',
                ],
            ])),
        ]);

        $response = $client->zones()->loadBalancers()->create('zone_id', [
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
    public function shouldGetLoadBalancerDetails()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode([
                'success' => true,
                'result' => [
                    'id' => 'load_balancer_id',
                ],
            ])),
        ]);

        $response = $client->zones()->loadBalancers()->details('zone_id', 'load_balancer_id');

        $this->assertTrue($response->successful());
        $this->assertSame('load_balancer_id', $response->json('result.id'));

        $this->assertSame('GET', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/zones/zone_id/load_balancers/load_balancer_id', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldUpdateLoadBalancer()
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

        $response = $client->zones()->loadBalancers()->update('zone_id', 'load_balancer_id', [
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
    public function shouldDeleteLoadBalancer()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode([
                'success' => true,
                'result' => [
                    'id' => 'load_balancer_id',
                ],
            ])),
        ]);

        $response = $client->zones()->loadBalancers()->delete('zone_id', 'load_balancer_id');

        $this->assertTrue($response->successful());

        $this->assertSame('DELETE', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/zones/zone_id/load_balancers/load_balancer_id', $this->lastRequest()->getUri()->getPath());
    }
}
