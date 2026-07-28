<?php

namespace Cloudflare\Tests\Endpoints\Workers;

use Cloudflare\Tests\Concerns\InteractsWithMockClient;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class SettingsTest extends TestCase
{
    use InteractsWithMockClient;

    #[Test]
    public function shouldGet()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => ['default_usage_model' => 'standard']])),
        ]);

        $response = $client->workers()->settings()->get('account_id');

        $this->assertTrue($response->successful());
        $this->assertSame('GET', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/accounts/account_id/workers/account-settings', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldCreate()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => ['default_usage_model' => 'standard']])),
        ]);

        $response = $client->workers()->settings()->create('account_id', 'standard', true);

        $this->assertTrue($response->successful());
        $this->assertSame('PUT', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/accounts/account_id/workers/account-settings', $this->lastRequest()->getUri()->getPath());
        $this->assertSame([
            'default_usage_model' => 'standard',
            'green_compute' => true,
        ], json_decode((string) $this->lastRequest()->getBody(), true));
    }
}
