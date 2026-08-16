<?php

namespace Cloudflare\Tests\Endpoints\Firewall;

use Cloudflare\Exceptions\MissingArgumentException;
use Cloudflare\Tests\Concerns\InteractsWithMockClient;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\Test;

class LockdownsTest extends TestCase
{
    use InteractsWithMockClient;

    #[Test]
    public function shouldList()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => [['id' => 'lockdown_id']]])),
        ]);

        $response = $client->firewall()->lockdowns()->list('zone_id');

        $this->assertTrue($response->successful());
        $this->assertSame('GET', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/zones/zone_id/firewall/lockdowns', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldCreate()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => ['id' => 'lockdown_id']])),
        ]);

        $response = $client->firewall()->lockdowns()->create('zone_id', [
            'urls' => ['example.com/*'],
            'configurations' => [['target' => 'ip', 'value' => '192.0.2.1']],
        ]);

        $this->assertTrue($response->successful());
        $this->assertSame('POST', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/zones/zone_id/firewall/lockdowns', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldGetDetails()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => ['id' => 'lockdown_id']])),
        ]);

        $response = $client->firewall()->lockdowns()->get('zone_id', 'lockdown_id');

        $this->assertTrue($response->successful());
        $this->assertSame('GET', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/zones/zone_id/firewall/lockdowns/lockdown_id', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldUpdate()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => ['id' => 'lockdown_id']])),
        ]);

        $response = $client->firewall()->lockdowns()->update('zone_id', 'lockdown_id', [
            'urls' => ['example.com/*'],
            'configurations' => [['target' => 'ip', 'value' => '192.0.2.1']],
        ]);

        $this->assertTrue($response->successful());
        $this->assertSame('PUT', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/zones/zone_id/firewall/lockdowns/lockdown_id', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldDelete()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => ['id' => 'lockdown_id']])),
        ]);

        $response = $client->firewall()->lockdowns()->delete('zone_id', 'lockdown_id');

        $this->assertTrue($response->successful());
        $this->assertSame('DELETE', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/zones/zone_id/firewall/lockdowns/lockdown_id', $this->lastRequest()->getUri()->getPath());
    }

    /**
     * Targets other than `ip` and `ip_range` used to be unreachable, because the
     * target was inferred from whether the value contained a slash.
     */
    #[Test]
    public function shouldCreateWithNonIpTargetsAndOptionalFields()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => ['id' => 'lockdown_id']])),
        ]);

        $values = [
            'urls' => ['example.com/admin*'],
            'configurations' => [
                ['target' => 'country', 'value' => 'US'],
                ['target' => 'asn', 'value' => 'AS13335'],
            ],
            'description' => 'Admin area',
            'priority' => 10,
            'paused' => false,
        ];

        $response = $client->firewall()->lockdowns()->create('zone_id', $values);

        $this->assertTrue($response->successful());
        $this->assertSame($values, json_decode((string) $this->lastRequest()->getBody(), true));
    }

    #[Test]
    public function shouldThrowWhenLockdownValuesAreMissing()
    {
        $client = $this->mockClient([]);

        $this->expectException(MissingArgumentException::class);

        $client->firewall()->lockdowns()->create('zone_id', ['urls' => ['example.com/*']]);
    }
}
