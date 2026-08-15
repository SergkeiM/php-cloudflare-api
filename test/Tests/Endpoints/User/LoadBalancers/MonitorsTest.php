<?php

namespace Cloudflare\Tests\Endpoints\User\LoadBalancers;

use Cloudflare\Tests\Concerns\InteractsWithMockClient;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\Test;

class MonitorsTest extends TestCase
{
    use InteractsWithMockClient;

    private function ok(array $result = []): Response
    {
        return new Response(200, [], json_encode(['success' => true, 'result' => $result]));
    }

    #[Test]
    public function shouldListMonitors()
    {
        $client = $this->mockClient([$this->ok([['id' => 'monitor_id']])]);

        $response = $client->user()->loadBalancers()->monitors()->list();

        $this->assertTrue($response->successful());
        $this->assertSame('monitor_id', $response->json('result.0.id'));

        $this->assertSame('GET', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/user/load_balancers/monitors', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldCreateMonitor()
    {
        $client = $this->mockClient([$this->ok(['id' => 'monitor_id'])]);

        $response = $client->user()->loadBalancers()->monitors()->create([
            'type' => 'https',
            'path' => '/health',
        ]);

        $this->assertTrue($response->successful());

        $this->assertSame('POST', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/user/load_balancers/monitors', $this->lastRequest()->getUri()->getPath());
        $this->assertSame(['type' => 'https', 'path' => '/health'], json_decode((string) $this->lastRequest()->getBody(), true));
    }

    #[Test]
    public function shouldGetMonitor()
    {
        $client = $this->mockClient([$this->ok(['id' => 'monitor_id'])]);

        $response = $client->user()->loadBalancers()->monitors()->get('monitor_id');

        $this->assertTrue($response->successful());

        $this->assertSame('GET', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/user/load_balancers/monitors/monitor_id', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldUpdateMonitor()
    {
        $client = $this->mockClient([$this->ok(['id' => 'monitor_id'])]);

        $response = $client->user()->loadBalancers()->monitors()->update('monitor_id', ['type' => 'http']);

        $this->assertTrue($response->successful());

        $this->assertSame('PUT', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/user/load_balancers/monitors/monitor_id', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldEditMonitor()
    {
        $client = $this->mockClient([$this->ok(['id' => 'monitor_id'])]);

        $response = $client->user()->loadBalancers()->monitors()->edit('monitor_id', ['description' => 'updated']);

        $this->assertTrue($response->successful());

        $this->assertSame('PATCH', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/user/load_balancers/monitors/monitor_id', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldDeleteMonitor()
    {
        $client = $this->mockClient([$this->ok()]);

        $response = $client->user()->loadBalancers()->monitors()->delete('monitor_id');

        $this->assertTrue($response->successful());

        $this->assertSame('DELETE', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/user/load_balancers/monitors/monitor_id', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldPreviewMonitor()
    {
        $client = $this->mockClient([$this->ok(['preview_id' => 'preview_id'])]);

        $response = $client->user()->loadBalancers()->monitors()->preview('monitor_id', ['path' => '/health']);

        $this->assertTrue($response->successful());
        $this->assertSame('preview_id', $response->json('result.preview_id'));

        $this->assertSame('POST', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/user/load_balancers/monitors/monitor_id/preview', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldListMonitorReferences()
    {
        $client = $this->mockClient([$this->ok([['reference_type' => 'referrer']])]);

        $response = $client->user()->loadBalancers()->monitors()->references('monitor_id');

        $this->assertTrue($response->successful());

        $this->assertSame('GET', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/user/load_balancers/monitors/monitor_id/references', $this->lastRequest()->getUri()->getPath());
    }
}
