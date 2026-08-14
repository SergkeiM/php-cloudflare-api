<?php

namespace Cloudflare\Tests\Endpoints\Workers;

use Cloudflare\Endpoints\Workers\Scripts;
use Cloudflare\Exceptions\MissingArgumentException;
use Cloudflare\Tests\Concerns\InteractsWithMockClient;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class ScriptsTest extends TestCase
{
    use InteractsWithMockClient;

    #[Test]
    public function shouldGet()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => [['id' => 'script_name']]])),
        ]);

        $response = $client->workers()->scripts()->list('account_id');

        $this->assertTrue($response->successful());
        $this->assertSame('GET', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/accounts/account_id/workers/scripts', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldDownload()
    {
        $client = $this->mockClient([
            new Response(200, [], 'export default { fetch() {} }'),
        ]);

        $response = $client->workers()->scripts()->download('account_id', 'script_name');

        $this->assertTrue($response->successful());
        $this->assertSame('GET', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/accounts/account_id/workers/scripts/script_name', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldUpload()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => ['id' => 'script_name']])),
        ]);

        $response = $client->workers()->scripts()->upload('account_id', 'script_name', [
            ['name' => 'worker.js', 'content' => 'export default {};'],
        ], [
            'compatibility_date' => '2026-01-01',
        ]);

        $body = (string) $this->lastRequest()->getBody();

        $this->assertTrue($response->successful());
        $this->assertSame('PUT', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/accounts/account_id/workers/scripts/script_name', $this->lastRequest()->getUri()->getPath());
        $this->assertStringStartsWith('multipart/form-data', $this->lastRequest()->getHeaderLine('Content-Type'));
        $this->assertStringContainsString('{"compatibility_date":"2026-01-01","main_module":"worker.js"}', $body);
        $this->assertStringContainsString('name="worker.js"; filename="worker.js"', $body);
        $this->assertStringContainsString('Content-Type: ' . Scripts::DEFAULT_MODULE_TYPE, $body);
        $this->assertStringContainsString('export default {};', $body);
    }

    #[Test]
    public function shouldUploadWithQueryParams()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => ['id' => 'script_name']])),
        ]);

        $response = $client->workers()->scripts()->upload('account_id', 'script_name', [
            ['name' => 'worker.js', 'content' => 'export default {};'],
        ], [], ['bindings_inherit' => 'strict']);

        $this->assertTrue($response->successful());
        $this->assertSame('bindings_inherit=strict', $this->lastRequest()->getUri()->getQuery());
    }

    #[Test]
    public function shouldThrowWhenUploadingWithoutModules()
    {
        $client = $this->mockClient([]);

        $this->expectException(MissingArgumentException::class);

        $client->workers()->scripts()->upload('account_id', 'script_name', []);
    }

    #[Test]
    public function shouldUpdateContent()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => ['id' => 'script_name']])),
        ]);

        $response = $client->workers()->scripts()->updateContent('account_id', 'script_name', [
            ['name' => 'worker.js', 'content' => 'export default {};'],
            ['name' => 'lib.wasm', 'content' => 'binary', 'type' => 'application/wasm'],
        ]);

        $body = (string) $this->lastRequest()->getBody();

        $this->assertTrue($response->successful());
        $this->assertSame('PUT', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/accounts/account_id/workers/scripts/script_name/content', $this->lastRequest()->getUri()->getPath());
        $this->assertStringContainsString('{"main_module":"worker.js"}', $body);
        $this->assertStringContainsString('Content-Type: application/wasm', $body);
    }

    #[Test]
    public function shouldThrowWhenUpdatingContentWithAnIncompleteModule()
    {
        $client = $this->mockClient([]);

        $this->expectException(MissingArgumentException::class);

        $client->workers()->scripts()->updateContent('account_id', 'script_name', [
            ['content' => 'export default {};'],
        ]);
    }

    #[Test]
    public function shouldGetContent()
    {
        $client = $this->mockClient([
            new Response(200, [], 'export default { fetch() {} }'),
        ]);

        $response = $client->workers()->scripts()->getContent('account_id', 'script_name');

        $this->assertTrue($response->successful());
        $this->assertSame('GET', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/accounts/account_id/workers/scripts/script_name/content/v2', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldGetScriptSettings()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => []])),
        ]);

        $response = $client->workers()->scripts()->getScriptSettings('account_id', 'script_name');

        $this->assertTrue($response->successful());
        $this->assertSame('GET', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/accounts/account_id/workers/scripts/script_name/script-settings', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldUpdateScriptSettings()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => []])),
        ]);

        $response = $client->workers()->scripts()->updateScriptSettings('account_id', 'script_name', ['logpush' => true]);

        $this->assertTrue($response->successful());
        $this->assertSame('PATCH', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/accounts/account_id/workers/scripts/script_name/script-settings', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldGetSettings()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => []])),
        ]);

        $response = $client->workers()->scripts()->getSettings('account_id', 'script_name');

        $this->assertTrue($response->successful());
        $this->assertSame('GET', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/accounts/account_id/workers/scripts/script_name/settings', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldUpdateSettings()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => []])),
        ]);

        $response = $client->workers()->scripts()->updateSettings('account_id', 'script_name', ['bindings' => []]);

        $this->assertTrue($response->successful());
        $this->assertSame('PATCH', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/accounts/account_id/workers/scripts/script_name/settings', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldGetUsageModel()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => ['usage_model' => 'standard']])),
        ]);

        $response = $client->workers()->scripts()->getUsageModel('account_id', 'script_name');

        $this->assertTrue($response->successful());
        $this->assertSame('GET', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/accounts/account_id/workers/scripts/script_name/usage-model', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldUpdateUsageModel()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => ['usage_model' => 'bundled']])),
        ]);

        $response = $client->workers()->scripts()->updateUsageModel('account_id', 'script_name', 'bundled');

        $this->assertTrue($response->successful());
        $this->assertSame('PUT', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/accounts/account_id/workers/scripts/script_name/usage-model', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldDelete()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => null])),
        ]);

        $response = $client->workers()->scripts()->delete('account_id', 'script_name', true);

        $this->assertTrue($response->successful());
        $this->assertSame('DELETE', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/accounts/account_id/workers/scripts/script_name', $this->lastRequest()->getUri()->getPath());
        $this->assertStringContainsString('force=', $this->lastRequest()->getUri()->getQuery());
    }
}
