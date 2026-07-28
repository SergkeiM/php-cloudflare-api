<?php

namespace Cloudflare\Tests\Endpoints\Zones;

use Cloudflare\Tests\Concerns\InteractsWithMockClient;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\Test;

class OriginCACertificatesTest extends TestCase
{
    use InteractsWithMockClient;

    #[Test]
    public function shouldListCertificates()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode([
                'success' => true,
                'result' => [
                    ['id' => 'certificate_id'],
                ],
            ])),
        ]);

        $response = $client->zones()->originCACertificates()->list(['zone_id' => 'zone_id']);

        $this->assertTrue($response->successful());
        $this->assertSame('certificate_id', $response->json('result.0.id'));

        $this->assertSame('GET', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/certificates', $this->lastRequest()->getUri()->getPath());
        $this->assertSame('zone_id=zone_id', $this->lastRequest()->getUri()->getQuery());
    }

    #[Test]
    public function shouldCreateCertificate()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode([
                'success' => true,
                'result' => [
                    'id' => 'certificate_id',
                ],
            ])),
        ]);

        $response = $client->zones()->originCACertificates()->create('csr_value', ['example.com']);

        $this->assertTrue($response->successful());
        $this->assertSame('certificate_id', $response->json('result.id'));

        $this->assertSame('POST', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/certificates', $this->lastRequest()->getUri()->getPath());
        $this->assertSame([
            'csr' => 'csr_value',
            'hostnames' => ['example.com'],
            'requested_validity' => 5475,
            'request_type' => 'origin-rsa',
        ], json_decode((string) $this->lastRequest()->getBody(), true));
    }

    #[Test]
    public function shouldGetCertificateDetails()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode([
                'success' => true,
                'result' => [
                    'id' => 'certificate_id',
                ],
            ])),
        ]);

        $response = $client->zones()->originCACertificates()->details('certificate_id');

        $this->assertTrue($response->successful());
        $this->assertSame('certificate_id', $response->json('result.id'));

        $this->assertSame('GET', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/certificates/certificate_id', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldRevokeCertificate()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode([
                'success' => true,
                'result' => [
                    'id' => 'certificate_id',
                ],
            ])),
        ]);

        $response = $client->zones()->originCACertificates()->revoke('certificate_id');

        $this->assertTrue($response->successful());
        $this->assertSame('certificate_id', $response->json('result.id'));

        $this->assertSame('DELETE', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/certificates/certificate_id', $this->lastRequest()->getUri()->getPath());
    }
}
