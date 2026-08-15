<?php

namespace Cloudflare\Tests\Endpoints;

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
            new Response(200, [], json_encode(['success' => true, 'result' => []])),
        ]);

        $response = $client->ssl()->verification('zone_id');

        $this->assertTrue($response->successful());
        $this->assertSame('GET', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/zones/zone_id/ssl/verification', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldEditVerification()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => []])),
        ]);

        $response = $client->ssl()->editVerification('zone_id', 'cert_pack_uuid', 'txt');

        $this->assertTrue($response->successful());
        $this->assertSame('PATCH', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/zones/zone_id/ssl/verification/cert_pack_uuid', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldGetUniversalSettings()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => ['enabled' => true]])),
        ]);

        $response = $client->ssl()->universalSettings('zone_id');

        $this->assertTrue($response->successful());
        $this->assertSame('GET', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/zones/zone_id/ssl/universal/settings', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldEditUniversalSettings()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => ['enabled' => false]])),
        ]);

        $response = $client->ssl()->editUniversalSettings('zone_id', false);

        $this->assertTrue($response->successful());
        $this->assertSame('PATCH', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/zones/zone_id/ssl/universal/settings', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldAnalyzeTheZonesOwnCertificate()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode([
                'success' => true,
                'result' => ['signature_algorithm' => 'SHA256WithRSA'],
            ])),
        ]);

        $response = $client->ssl()->analyze('zone_id');

        $this->assertTrue($response->successful());
        $this->assertSame('SHA256WithRSA', $response->json('result.signature_algorithm'));

        $this->assertSame('POST', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/zones/zone_id/ssl/analyze', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldAnalyzeASuppliedCertificate()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => []])),
        ]);

        $values = [
            'certificate' => '-----BEGIN CERTIFICATE-----\nMIID...\n-----END CERTIFICATE-----',
            'bundle_method' => 'optimal',
        ];

        $client->ssl()->analyze('zone_id', $values);

        $this->assertSame($values, json_decode((string) $this->lastRequest()->getBody(), true));
    }
}
