<?php

namespace Cloudflare\Tests\Endpoints;

use Cloudflare\Tests\Concerns\InteractsWithMockClient;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\Test;

class OriginCACertificatesTest extends TestCase
{
    use InteractsWithMockClient;

    #[Test]
    public function shouldList()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => [['id' => 'certificate_id']]])),
        ]);

        $response = $client->originCACertificates()->list();

        $this->assertTrue($response->successful());
        $this->assertSame('GET', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/certificates', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldCreate()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => ['id' => 'certificate_id']])),
        ]);

        $response = $client->originCACertificates()->create('csr', ['example.com']);

        $this->assertTrue($response->successful());
        $this->assertSame('POST', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/certificates', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldGet()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => ['id' => 'certificate_id']])),
        ]);

        $response = $client->originCACertificates()->get('certificate_id');

        $this->assertTrue($response->successful());
        $this->assertSame('GET', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/certificates/certificate_id', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldRevoke()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => ['id' => 'certificate_id']])),
        ]);

        $response = $client->originCACertificates()->revoke('certificate_id');

        $this->assertTrue($response->successful());
        $this->assertSame('DELETE', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/certificates/certificate_id', $this->lastRequest()->getUri()->getPath());
    }
}
