<?php

namespace Cloudflare\Tests\Endpoints\Workers;

use Cloudflare\Exceptions\BadMethodCallException;
use Cloudflare\Tests\Concerns\InteractsWithMockClient;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class EnvironmentTest extends TestCase
{
    use InteractsWithMockClient;

    #[Test]
    public function shouldGet()
    {
        $client = $this->mockClient([
            new Response(200, [], 'script content'),
        ]);

        $response = $client->workers()->environment()->get('account_id', 'service_name', 'production');

        $this->assertTrue($response->successful());
        $this->assertSame('GET', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/accounts/account_id/workers/services/service_name/environments/production/content', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldThrowOnUpdate()
    {
        $client = $this->mockClient([]);

        $this->expectException(BadMethodCallException::class);

        $client->workers()->environment()->update('account_id', 'service_name', 'production');
    }

    #[Test]
    public function shouldGetSettings()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => []])),
        ]);

        $response = $client->workers()->environment()->getSettings('account_id', 'service_name', 'production');

        $this->assertTrue($response->successful());
        $this->assertSame('GET', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/accounts/account_id/workers/services/service_name/environments/production/settings', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldUpdateSettings()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => []])),
        ]);

        $response = $client->workers()->environment()->updateSettings('account_id', 'service_name', 'production', [
            'bindings' => [],
        ]);

        $this->assertTrue($response->successful());
        $this->assertSame('PATCH', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/accounts/account_id/workers/services/service_name/environments/production/settings', $this->lastRequest()->getUri()->getPath());
    }
}
