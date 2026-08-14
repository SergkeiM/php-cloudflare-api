<?php

namespace Cloudflare\Tests\Endpoints\Workers;

use Cloudflare\Endpoints\Workers\Environment;
use Cloudflare\Exceptions\MissingArgumentException;
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
    public function shouldUpdateContent()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => ['id' => 'script_id']])),
        ]);

        $response = $client->workers()->environment()->update('account_id', 'service_name', 'production', [
            ['name' => 'worker.js', 'content' => 'export default {};'],
        ]);

        $body = (string) $this->lastRequest()->getBody();

        $this->assertTrue($response->successful());
        $this->assertSame('PUT', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/accounts/account_id/workers/services/service_name/environments/production/content', $this->lastRequest()->getUri()->getPath());
        $this->assertStringStartsWith('multipart/form-data', $this->lastRequest()->getHeaderLine('Content-Type'));
        $this->assertStringContainsString('{"main_module":"worker.js"}', $body);
        $this->assertStringContainsString('name="worker.js"; filename="worker.js"', $body);
        $this->assertStringContainsString('Content-Type: ' . Environment::DEFAULT_MODULE_TYPE, $body);
    }

    #[Test]
    public function shouldThrowWhenUpdatingWithoutModules()
    {
        $client = $this->mockClient([]);

        $this->expectException(MissingArgumentException::class);

        $client->workers()->environment()->update('account_id', 'service_name', 'production', []);
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
