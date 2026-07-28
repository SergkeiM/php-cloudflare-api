<?php

namespace Cloudflare\Tests\Endpoints\Accounts;

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

        $response = $client->accounts()->loadBalancers()->list('account_id');

        $this->assertTrue($response->successful());
        $this->assertSame('load_balancer_id', $response->json('result.0.id'));

        $this->assertSame('GET', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/accounts/account_id/load_balancers', $this->lastRequest()->getUri()->getPath());
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

        $response = $client->accounts()->loadBalancers()->create('account_id', [
            'name' => 'www.example.com',
            'default_pools' => ['pool_id'],
            'fallback_pool' => 'pool_id',
        ]);

        $this->assertTrue($response->successful());
        $this->assertSame('load_balancer_id', $response->json('result.id'));

        $this->assertSame('POST', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/accounts/account_id/load_balancers', $this->lastRequest()->getUri()->getPath());
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

        $response = $client->accounts()->loadBalancers()->details('account_id', 'load_balancer_id');

        $this->assertTrue($response->successful());
        $this->assertSame('load_balancer_id', $response->json('result.id'));

        $this->assertSame('GET', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/accounts/account_id/load_balancers/load_balancer_id', $this->lastRequest()->getUri()->getPath());
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

        $response = $client->accounts()->loadBalancers()->update('account_id', 'load_balancer_id', [
            'name' => 'www.example.com',
            'default_pools' => ['pool_id'],
            'fallback_pool' => 'pool_id',
            'enabled' => false,
        ]);

        $this->assertTrue($response->successful());
        $this->assertFalse($response->json('result.enabled'));

        $this->assertSame('PUT', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/accounts/account_id/load_balancers/load_balancer_id', $this->lastRequest()->getUri()->getPath());
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

        $response = $client->accounts()->loadBalancers()->delete('account_id', 'load_balancer_id');

        $this->assertTrue($response->successful());

        $this->assertSame('DELETE', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/accounts/account_id/load_balancers/load_balancer_id', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldPatchLoadBalancer()
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

        $response = $client->accounts()->loadBalancers()->patch('account_id', 'load_balancer_id', [
            'enabled' => false,
        ]);

        $this->assertTrue($response->successful());
        $this->assertFalse($response->json('result.enabled'));

        $this->assertSame('PATCH', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/accounts/account_id/load_balancers/load_balancer_id', $this->lastRequest()->getUri()->getPath());
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

        $response = $client->accounts()->loadBalancers()->usage('account_id');

        $this->assertTrue($response->successful());
        $this->assertSame(1, $response->json('result.load_balancers'));

        $this->assertSame('GET', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/accounts/account_id/load_balancers/usage', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldSearchLoadBalancerResources()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode([
                'success' => true,
                'result' => [
                    ['id' => 'load_balancer_id'],
                ],
            ])),
        ]);

        $response = $client->accounts()->loadBalancers()->search('account_id', [
            'query' => 'www.example.com',
        ]);

        $this->assertTrue($response->successful());
        $this->assertSame('load_balancer_id', $response->json('result.0.id'));

        $this->assertSame('GET', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/accounts/account_id/load_balancers/search', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldGetPreviewResult()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode([
                'success' => true,
                'result' => [
                    'preview_id' => 'preview_id',
                ],
            ])),
        ]);

        $response = $client->accounts()->loadBalancers()->previewResult('account_id', 'preview_id');

        $this->assertTrue($response->successful());
        $this->assertSame('preview_id', $response->json('result.preview_id'));

        $this->assertSame('GET', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/accounts/account_id/load_balancers/preview/preview_id', $this->lastRequest()->getUri()->getPath());
    }
}
