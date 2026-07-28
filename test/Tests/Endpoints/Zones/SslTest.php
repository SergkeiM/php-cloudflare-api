<?php

namespace Cloudflare\Tests\Endpoints\Zones;

use Cloudflare\Tests\Concerns\InteractsWithMockClient;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\Test;

class SslTest extends TestCase
{
    use InteractsWithMockClient;

    #[Test]
    public function shouldGetVerification()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode([
                'success' => true,
                'result' => [
                    'certificate_status' => 'active',
                ],
            ])),
        ]);

        $response = $client->zones()->ssl()->verification('zone_id');

        $this->assertTrue($response->successful());
        $this->assertSame('active', $response->json('result.certificate_status'));

        $this->assertSame('GET', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/zones/zone_id/ssl/verification', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldEditVerification()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode([
                'success' => true,
                'result' => [
                    'validation_method' => 'txt',
                ],
            ])),
        ]);

        $response = $client->zones()->ssl()->editVerification('zone_id', 'cert_pack_uuid', 'txt');

        $this->assertTrue($response->successful());
        $this->assertSame('txt', $response->json('result.validation_method'));

        $this->assertSame('PATCH', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/zones/zone_id/ssl/verification/cert_pack_uuid', $this->lastRequest()->getUri()->getPath());
        $this->assertSame([
            'validation_method' => 'txt',
        ], json_decode((string) $this->lastRequest()->getBody(), true));
    }

    #[Test]
    public function shouldGetUniversalSettings()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode([
                'success' => true,
                'result' => [
                    'enabled' => true,
                ],
            ])),
        ]);

        $response = $client->zones()->ssl()->universalSettings('zone_id');

        $this->assertTrue($response->successful());
        $this->assertTrue($response->json('result.enabled'));

        $this->assertSame('GET', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/zones/zone_id/ssl/universal/settings', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldUpdateUniversalSettings()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode([
                'success' => true,
                'result' => [
                    'enabled' => false,
                ],
            ])),
        ]);

        $response = $client->zones()->ssl()->updateUniversalSettings('zone_id', false);

        $this->assertTrue($response->successful());
        $this->assertFalse($response->json('result.enabled'));

        $this->assertSame('PATCH', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/zones/zone_id/ssl/universal/settings', $this->lastRequest()->getUri()->getPath());
        $this->assertSame([
            'enabled' => false,
        ], json_decode((string) $this->lastRequest()->getBody(), true));
    }
}
