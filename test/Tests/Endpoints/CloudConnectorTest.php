<?php

namespace Cloudflare\Tests\Endpoints;

use Cloudflare\Tests\Concerns\InteractsWithMockClient;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\Test;

class CloudConnectorTest extends TestCase
{
    use InteractsWithMockClient;

    #[Test]
    public function shouldGet()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => []])),
        ]);

        $response = $client->cloudConnector()->get('zone_id');

        $this->assertTrue($response->successful());
        $this->assertSame('GET', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/zones/zone_id/cloud_connector/rules', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldUpdate()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => []])),
        ]);

        $response = $client->cloudConnector()->update('zone_id', [
            'name' => 'my rule',
            'expression' => 'true',
            'provider' => 'aws_s3',
            'enabled' => true,
        ]);

        $this->assertTrue($response->successful());
        $this->assertSame('PUT', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/zones/zone_id/cloud_connector/rules', $this->lastRequest()->getUri()->getPath());
    }
}
