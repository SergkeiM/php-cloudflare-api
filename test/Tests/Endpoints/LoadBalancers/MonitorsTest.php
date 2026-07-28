<?php

namespace Cloudflare\Tests\Endpoints\LoadBalancers;

use Cloudflare\Tests\Concerns\InteractsWithMockClient;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\Test;

class MonitorsTest extends TestCase
{
    use InteractsWithMockClient;

    #[Test]
    public function shouldListMonitors()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode([
                'success' => true,
                'result' => [
                    ['id' => 'monitor_id'],
                ],
            ])),
        ]);

        $response = $client->loadBalancers()->monitors()->list('account_id');

        $this->assertTrue($response->successful());
        $this->assertSame('monitor_id', $response->json('result.0.id'));

        $this->assertSame('GET', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/accounts/account_id/load_balancers/monitors', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldCreateMonitor()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode([
                'success' => true,
                'result' => [
                    'id' => 'monitor_id',
                ],
            ])),
        ]);

        $response = $client->loadBalancers()->monitors()->create('account_id', [
            'type' => 'http',
            'method' => 'GET',
            'path' => '/health',
        ]);

        $this->assertTrue($response->successful());
        $this->assertSame('monitor_id', $response->json('result.id'));

        $this->assertSame('POST', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/accounts/account_id/load_balancers/monitors', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldGetMonitorDetails()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode([
                'success' => true,
                'result' => [
                    'id' => 'monitor_id',
                ],
            ])),
        ]);

        $response = $client->loadBalancers()->monitors()->get('account_id', 'monitor_id');

        $this->assertTrue($response->successful());
        $this->assertSame('monitor_id', $response->json('result.id'));

        $this->assertSame('GET', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/accounts/account_id/load_balancers/monitors/monitor_id', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldUpdateMonitor()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode([
                'success' => true,
                'result' => [
                    'id' => 'monitor_id',
                    'method' => 'POST',
                ],
            ])),
        ]);

        $response = $client->loadBalancers()->monitors()->update('account_id', 'monitor_id', [
            'type' => 'http',
            'method' => 'POST',
        ]);

        $this->assertTrue($response->successful());
        $this->assertSame('POST', $response->json('result.method'));

        $this->assertSame('PUT', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/accounts/account_id/load_balancers/monitors/monitor_id', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldEditMonitor()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode([
                'success' => true,
                'result' => [
                    'id' => 'monitor_id',
                    'method' => 'POST',
                ],
            ])),
        ]);

        $response = $client->loadBalancers()->monitors()->edit('account_id', 'monitor_id', [
            'method' => 'POST',
        ]);

        $this->assertTrue($response->successful());
        $this->assertSame('POST', $response->json('result.method'));

        $this->assertSame('PATCH', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/accounts/account_id/load_balancers/monitors/monitor_id', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldDeleteMonitor()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode([
                'success' => true,
                'result' => [
                    'id' => 'monitor_id',
                ],
            ])),
        ]);

        $response = $client->loadBalancers()->monitors()->delete('account_id', 'monitor_id');

        $this->assertTrue($response->successful());

        $this->assertSame('DELETE', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/accounts/account_id/load_balancers/monitors/monitor_id', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldPreviewMonitor()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode([
                'success' => true,
                'result' => [
                    'preview_id' => 'preview_id',
                ],
            ])),
        ]);

        $response = $client->loadBalancers()->monitors()->preview('account_id', 'monitor_id', [
            'pools' => ['pool_id'],
        ]);

        $this->assertTrue($response->successful());
        $this->assertSame('preview_id', $response->json('result.preview_id'));

        $this->assertSame('POST', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/accounts/account_id/load_balancers/monitors/monitor_id/preview', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldListMonitorReferences()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode([
                'success' => true,
                'result' => [
                    ['reference_type' => 'referral', 'resource_id' => 'load_balancer_id'],
                ],
            ])),
        ]);

        $response = $client->loadBalancers()->monitors()->references('account_id', 'monitor_id');

        $this->assertTrue($response->successful());
        $this->assertSame('load_balancer_id', $response->json('result.0.resource_id'));

        $this->assertSame('GET', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/accounts/account_id/load_balancers/monitors/monitor_id/references', $this->lastRequest()->getUri()->getPath());
    }
}
