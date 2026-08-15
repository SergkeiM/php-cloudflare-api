<?php

namespace Cloudflare\Tests\Endpoints\User;

use Cloudflare\Tests\Concerns\InteractsWithMockClient;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\Test;

class LoadBalancersTest extends TestCase
{
    use InteractsWithMockClient;

    #[Test]
    public function shouldListRegions()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode([
                'success' => true,
                'result' => ['WNAM' => ['US']],
            ])),
        ]);

        $response = $client->user()->loadBalancers()->regions(['country_code' => 'US']);

        $this->assertTrue($response->successful());

        $this->assertSame('GET', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/user/load_balancers/regions', $this->lastRequest()->getUri()->getPath());
        $this->assertSame('country_code=US', $this->lastRequest()->getUri()->getQuery());
    }

    #[Test]
    public function shouldGetPreviewResult()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode([
                'success' => true,
                'result' => ['pool_id' => ['healthy' => true]],
            ])),
        ]);

        $response = $client->user()->loadBalancers()->preview('preview_id');

        $this->assertTrue($response->successful());

        $this->assertSame('GET', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/user/load_balancers/preview/preview_id', $this->lastRequest()->getUri()->getPath());
    }

    /**
     * Healthcheck events sit under their own path root, not under
     * `/user/load_balancers`.
     */
    #[Test]
    public function shouldListHealthcheckEvents()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode([
                'success' => true,
                'result' => [
                    ['pool_healthy' => false, 'origin_name' => 'origin'],
                ],
            ])),
        ]);

        $response = $client->user()->loadBalancers()->healthcheckEvents([
            'pool_healthy' => false,
        ]);

        $this->assertTrue($response->successful());
        $this->assertSame('origin', $response->json('result.0.origin_name'));

        $this->assertSame('GET', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/user/load_balancing_analytics/events', $this->lastRequest()->getUri()->getPath());
    }
}
