<?php

namespace Cloudflare\Tests\Endpoints\Workers;

use Cloudflare\Endpoints\Workers\Versions;
use Cloudflare\Exceptions\MissingArgumentException;
use Cloudflare\Tests\Concerns\InteractsWithMockClient;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class VersionsTest extends TestCase
{
    use InteractsWithMockClient;

    #[Test]
    public function shouldList()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => [['id' => 'version_id']]])),
        ]);

        $response = $client->workers()->versions()->list('account_id', 'script_name');

        $this->assertTrue($response->successful());
        $this->assertSame('GET', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/accounts/account_id/workers/scripts/script_name/versions', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldUpload()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => ['id' => 'version_id']])),
        ]);

        $response = $client->workers()->versions()->upload('account_id', 'script_name', [
            ['name' => 'worker.js', 'content' => 'export default {};'],
        ], [
            'compatibility_date' => '2026-01-01',
        ]);

        $body = (string) $this->lastRequest()->getBody();

        $this->assertTrue($response->successful());
        $this->assertSame('POST', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/accounts/account_id/workers/scripts/script_name/versions', $this->lastRequest()->getUri()->getPath());
        $this->assertStringStartsWith('multipart/form-data', $this->lastRequest()->getHeaderLine('Content-Type'));
        $this->assertStringContainsString('name="metadata"', $body);
        $this->assertStringContainsString('{"compatibility_date":"2026-01-01","main_module":"worker.js"}', $body);
        $this->assertStringContainsString('name="worker.js"; filename="worker.js"', $body);
        $this->assertStringContainsString('Content-Type: ' . Versions::DEFAULT_MODULE_TYPE, $body);
        $this->assertStringContainsString('export default {};', $body);
    }

    #[Test]
    public function shouldUploadSeveralModulesWithTheirOwnTypes()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => ['id' => 'version_id']])),
        ]);

        $response = $client->workers()->versions()->upload('account_id', 'script_name', [
            ['name' => 'index.js', 'content' => 'export default {};'],
            ['name' => 'lib.wasm', 'content' => 'binary', 'type' => 'application/wasm'],
        ]);

        $body = (string) $this->lastRequest()->getBody();

        $this->assertTrue($response->successful());
        $this->assertStringContainsString('name="index.js"; filename="index.js"', $body);
        $this->assertStringContainsString('name="lib.wasm"; filename="lib.wasm"', $body);
        $this->assertStringContainsString('Content-Type: application/wasm', $body);
        $this->assertStringContainsString('{"main_module":"index.js"}', $body);
    }

    /**
     * A service worker names its entry point with `body_part` instead, so the
     * module entry point must not be filled in over it.
     */
    #[Test]
    public function shouldKeepTheEntryPointTheMetadataAlreadyNames()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => ['id' => 'version_id']])),
            new Response(200, [], json_encode(['success' => true, 'result' => ['id' => 'version_id']])),
        ]);

        $client->workers()->versions()->upload('account_id', 'script_name', [
            ['name' => 'worker.js', 'content' => 'addEventListener("fetch", () => {});', 'type' => 'application/javascript'],
        ], ['body_part' => 'worker.js']);

        $this->assertStringContainsString('{"body_part":"worker.js"}', (string) $this->lastRequest()->getBody());

        $client->workers()->versions()->upload('account_id', 'script_name', [
            ['name' => 'a.js', 'content' => 'export default {};'],
            ['name' => 'b.js', 'content' => 'export default {};'],
        ], ['main_module' => 'b.js']);

        $this->assertStringContainsString('{"main_module":"b.js"}', (string) $this->lastRequest()->getBody());
    }

    #[Test]
    public function shouldThrowWhenUploadingWithoutModules()
    {
        $client = $this->mockClient([]);

        $this->expectException(MissingArgumentException::class);

        $client->workers()->versions()->upload('account_id', 'script_name', []);
    }

    #[Test]
    public function shouldThrowWhenAModuleIsIncomplete()
    {
        $client = $this->mockClient([]);

        $this->expectException(MissingArgumentException::class);

        $client->workers()->versions()->upload('account_id', 'script_name', [
            ['name' => 'worker.js'],
        ]);
    }

    #[Test]
    public function shouldGetDetails()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => ['id' => 'version_id']])),
        ]);

        $response = $client->workers()->versions()->get('account_id', 'script_name', 'version_id');

        $this->assertTrue($response->successful());
        $this->assertSame('GET', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/accounts/account_id/workers/scripts/script_name/versions/version_id', $this->lastRequest()->getUri()->getPath());
    }
}
