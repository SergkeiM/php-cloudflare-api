<?php

namespace Cloudflare\Tests\Endpoints\Accounts;

use Cloudflare\Tests\Concerns\InteractsWithMockClient;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\Test;

class R2MetricsTest extends TestCase
{
    use InteractsWithMockClient;

    #[Test]
    public function shouldGetMetrics()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode([
                'success' => true,
                'result' => [
                    'payloadSize' => 1024,
                ],
            ])),
        ]);

        $response = $client->accounts()->r2Metrics()->list('account_id');

        $this->assertTrue($response->successful());
        $this->assertSame(1024, $response->json('result.payloadSize'));

        $this->assertSame('GET', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/accounts/account_id/r2/metrics', $this->lastRequest()->getUri()->getPath());
    }
}
