<?php

namespace Cloudflare\Tests\Endpoints\Ssl;

use Cloudflare\Exceptions\MissingArgumentException;
use Cloudflare\Tests\Concerns\InteractsWithMockClient;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\Test;

class CertificatePacksTest extends TestCase
{
    use InteractsWithMockClient;

    /**
     * @return array
     */
    private function order(): array
    {
        return [
            'certificate_authority' => 'lets_encrypt',
            'hosts' => ['example.com', 'www.example.com'],
            'validation_method' => 'txt',
            'validity_days' => 90,
        ];
    }

    #[Test]
    public function shouldListCertificatePacks()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode([
                'success' => true,
                'result' => [
                    ['id' => 'pack_id', 'status' => 'active'],
                ],
            ])),
        ]);

        $response = $client->ssl()->certificatePacks()->list('zone_id', ['status' => 'all']);

        $this->assertTrue($response->successful());
        $this->assertSame('pack_id', $response->json('result.0.id'));

        $this->assertSame('GET', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/zones/zone_id/ssl/certificate_packs', $this->lastRequest()->getUri()->getPath());
        $this->assertSame('status=all', $this->lastRequest()->getUri()->getQuery());
    }

    #[Test]
    public function shouldGetQuota()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode([
                'success' => true,
                'result' => ['advanced' => ['allocated' => 5, 'used' => 1]],
            ])),
        ]);

        $response = $client->ssl()->certificatePacks()->quota('zone_id');

        $this->assertTrue($response->successful());
        $this->assertSame(5, $response->json('result.advanced.allocated'));

        $this->assertSame('GET', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/zones/zone_id/ssl/certificate_packs/quota', $this->lastRequest()->getUri()->getPath());
    }

    /**
     * `type` has exactly one legal value, so it is filled in rather than left
     * for the caller to remember.
     */
    #[Test]
    public function shouldOrderCertificatePackWithTheAdvancedType()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode([
                'success' => true,
                'result' => ['id' => 'pack_id', 'status' => 'pending_validation'],
            ])),
        ]);

        $response = $client->ssl()->certificatePacks()->order('zone_id', $this->order());

        $this->assertTrue($response->successful());
        $this->assertSame('pending_validation', $response->json('result.status'));

        $this->assertSame('POST', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/zones/zone_id/ssl/certificate_packs/order', $this->lastRequest()->getUri()->getPath());
        $this->assertSame(
            array_merge(['type' => 'advanced'], $this->order()),
            json_decode((string) $this->lastRequest()->getBody(), true)
        );
    }

    #[Test]
    public function shouldThrowWhenOrderIsMissingRequiredValues()
    {
        $client = $this->mockClient([]);

        $this->expectException(MissingArgumentException::class);

        $client->ssl()->certificatePacks()->order('zone_id', [
            'certificate_authority' => 'lets_encrypt',
        ]);
    }

    #[Test]
    public function shouldGetCertificatePack()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode([
                'success' => true,
                'result' => ['id' => 'pack_id'],
            ])),
        ]);

        $response = $client->ssl()->certificatePacks()->get('zone_id', 'pack_id');

        $this->assertTrue($response->successful());

        $this->assertSame('GET', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/zones/zone_id/ssl/certificate_packs/pack_id', $this->lastRequest()->getUri()->getPath());
    }

    /**
     * An empty body is the "restart validation" call, so it must still be sent
     * as a PATCH to the pack.
     */
    #[Test]
    public function shouldRestartValidationWithAnEmptyBody()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode([
                'success' => true,
                'result' => ['id' => 'pack_id', 'status' => 'pending_validation'],
            ])),
        ]);

        $response = $client->ssl()->certificatePacks()->edit('zone_id', 'pack_id');

        $this->assertTrue($response->successful());

        $this->assertSame('PATCH', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/zones/zone_id/ssl/certificate_packs/pack_id', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldUpdateCloudflareBranding()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => ['id' => 'pack_id']])),
        ]);

        $client->ssl()->certificatePacks()->edit('zone_id', 'pack_id', ['cloudflare_branding' => true]);

        $this->assertSame(['cloudflare_branding' => true], json_decode((string) $this->lastRequest()->getBody(), true));
    }

    #[Test]
    public function shouldDeleteCertificatePack()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => ['id' => 'pack_id']])),
        ]);

        $response = $client->ssl()->certificatePacks()->delete('zone_id', 'pack_id');

        $this->assertTrue($response->successful());

        $this->assertSame('DELETE', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/zones/zone_id/ssl/certificate_packs/pack_id', $this->lastRequest()->getUri()->getPath());
    }
}
