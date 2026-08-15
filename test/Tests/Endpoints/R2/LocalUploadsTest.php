<?php

namespace Cloudflare\Tests\Endpoints\R2;

use Cloudflare\Tests\Concerns\InteractsWithMockClient;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\TestWith;

class LocalUploadsTest extends TestCase
{
    use InteractsWithMockClient;

    #[Test]
    public function shouldGetConfiguration()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode([
                'success' => true,
                'result' => ['enabled' => true],
            ])),
        ]);

        $response = $client->r2()->localUploads()->get('account_id', 'my-bucket');

        $this->assertTrue($response->successful());
        $this->assertTrue($response->json('result.enabled'));

        $this->assertSame('GET', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/accounts/account_id/r2/buckets/my-bucket/local-uploads', $this->lastRequest()->getUri()->getPath());
    }

    /**
     * Disabling has to send `false` rather than dropping the key, so the
     * boolean is carried through as given.
     */
    #[TestWith([true])]
    #[TestWith([false])]
    #[Test]
    public function shouldUpdateConfiguration(bool $enabled)
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode([
                'success' => true,
                'result' => ['enabled' => $enabled],
            ])),
        ]);

        $response = $client->r2()->localUploads()->update('account_id', 'my-bucket', $enabled);

        $this->assertTrue($response->successful());

        $this->assertSame('PUT', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/accounts/account_id/r2/buckets/my-bucket/local-uploads', $this->lastRequest()->getUri()->getPath());
        $this->assertSame(['enabled' => $enabled], json_decode((string) $this->lastRequest()->getBody(), true));
    }
}
