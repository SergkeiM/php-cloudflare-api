<?php

namespace Cloudflare\Tests\Endpoints\Zones;

use Cloudflare\Tests\Concerns\InteractsWithMockClient;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\Test;

class BotManagementTest extends TestCase
{
    use InteractsWithMockClient;

    #[Test]
    public function shouldGetBotManagementDetails()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode([
                'success' => true,
                'result' => [
                    'fight_mode' => true,
                ],
            ])),
        ]);

        $response = $client->zones()->botManagement()->details('zone_id');

        $this->assertTrue($response->successful());
        $this->assertTrue($response->json('result.fight_mode'));

        $this->assertSame('GET', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/zones/zone_id/bot_management', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldUpdateBotManagement()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode([
                'success' => true,
                'result' => [
                    'fight_mode' => false,
                ],
            ])),
        ]);

        $response = $client->zones()->botManagement()->update('zone_id', [
            'fight_mode' => false,
        ]);

        $this->assertTrue($response->successful());
        $this->assertFalse($response->json('result.fight_mode'));

        $this->assertSame('PUT', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/zones/zone_id/bot_management', $this->lastRequest()->getUri()->getPath());
        $this->assertSame(['fight_mode' => false], json_decode((string) $this->lastRequest()->getBody(), true));
    }
}
