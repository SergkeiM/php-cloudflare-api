<?php

namespace Cloudflare\Tests\Endpoints\Zones\Settings;

use Cloudflare\Exceptions\MissingArgumentException;
use Cloudflare\Tests\Concerns\InteractsWithMockClient;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\Test;

class GoogleTagGatewayTest extends TestCase
{
    use InteractsWithMockClient;

    #[Test]
    public function shouldGetConfiguration()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode([
                'success' => true,
                'result' => [
                    'enabled' => true,
                    'measurementId' => 'G-XXXXXXXXXX',
                ],
            ])),
        ]);

        $response = $client->zones()->settings()->googleTagGateway()->get('zone_id');

        $this->assertTrue($response->successful());
        $this->assertTrue($response->json('result.enabled'));

        $this->assertSame('GET', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/zones/zone_id/settings/google-tag-gateway/config', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldUpdateConfiguration()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode([
                'success' => true,
                'result' => ['enabled' => true],
            ])),
        ]);

        $values = [
            'enabled' => true,
            'endpoint' => '/analytics',
            'hideOriginalIp' => false,
            'measurementId' => 'G-XXXXXXXXXX',
        ];

        $response = $client->zones()->settings()->googleTagGateway()->update('zone_id', $values);

        $this->assertTrue($response->successful());

        $this->assertSame('PUT', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/zones/zone_id/settings/google-tag-gateway/config', $this->lastRequest()->getUri()->getPath());
        $this->assertSame($values, json_decode((string) $this->lastRequest()->getBody(), true));
    }

    #[Test]
    public function shouldAcceptFalseForTheBooleanFields()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode([
                'success' => true,
                'result' => ['enabled' => false],
            ])),
        ]);

        // `enabled => false` is a meaningful body, so the required-key check
        // must look at keys rather than at truthiness.
        $response = $client->zones()->settings()->googleTagGateway()->update('zone_id', [
            'enabled' => false,
            'endpoint' => '/analytics',
            'hideOriginalIp' => false,
            'measurementId' => 'G-XXXXXXXXXX',
        ]);

        $this->assertTrue($response->successful());
        $this->assertFalse($response->json('result.enabled'));
    }

    #[Test]
    public function shouldThrowWhenRequiredValuesAreMissing()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true])),
        ]);

        $this->expectException(MissingArgumentException::class);

        $client->zones()->settings()->googleTagGateway()->update('zone_id', [
            'enabled' => true,
        ]);
    }
}
