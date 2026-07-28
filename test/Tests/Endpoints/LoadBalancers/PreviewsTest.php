<?php

namespace Cloudflare\Tests\Endpoints\LoadBalancers;

use Cloudflare\Tests\Concerns\InteractsWithMockClient;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\Test;

class PreviewsTest extends TestCase
{
    use InteractsWithMockClient;

    #[Test]
    public function shouldGetPreviewResult()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode([
                'success' => true,
                'result' => [
                    'preview_id' => 'preview_id',
                ],
            ])),
        ]);

        $response = $client->loadBalancers()->previews()->get('account_id', 'preview_id');

        $this->assertTrue($response->successful());
        $this->assertSame('preview_id', $response->json('result.preview_id'));

        $this->assertSame('GET', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/accounts/account_id/load_balancers/preview/preview_id', $this->lastRequest()->getUri()->getPath());
    }
}
