<?php

namespace Cloudflare\Tests\Endpoints\LoadBalancers;

use Cloudflare\Tests\Concerns\InteractsWithMockClient;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\Test;

class SearchesTest extends TestCase
{
    use InteractsWithMockClient;

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

        $response = $client->loadBalancers()->searches()->list('account_id', [
            'query' => 'www.example.com',
        ]);

        $this->assertTrue($response->successful());
        $this->assertSame('load_balancer_id', $response->json('result.0.id'));

        $this->assertSame('GET', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/accounts/account_id/load_balancers/search', $this->lastRequest()->getUri()->getPath());
    }
}
