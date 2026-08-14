<?php

namespace Cloudflare\Tests\Endpoints\Zones;

use Cloudflare\Exceptions\MissingArgumentException;
use Cloudflare\Tests\Concerns\InteractsWithMockClient;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\TestWith;
use PHPUnit\Framework\TestCase;

class SettingsTest extends TestCase
{
    use InteractsWithMockClient;

    #[Test]
    public function shouldList()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => [
                ['id' => 'always_use_https', 'value' => 'off', 'editable' => true],
                ['id' => 'browser_cache_ttl', 'value' => 14400, 'editable' => true],
            ]])),
        ]);

        $response = $client->zones()->settings()->list('zone_id');

        $this->assertTrue($response->successful());
        $this->assertSame('GET', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/zones/zone_id/settings', $this->lastRequest()->getUri()->getPath());
        $this->assertSame('always_use_https', $response->json('result.0.id'));
    }

    #[Test]
    public function shouldGetDetails()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => ['id' => 'always_use_https', 'value' => 'on']])),
        ]);

        $response = $client->zones()->settings()->get('zone_id', 'always_use_https');

        $this->assertTrue($response->successful());
        $this->assertSame('GET', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/zones/zone_id/settings/always_use_https', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldEdit()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => ['id' => 'always_use_https', 'value' => 'on']])),
        ]);

        $response = $client->zones()->settings()->edit('zone_id', 'always_use_https', ['value' => 'on']);

        $this->assertTrue($response->successful());
        $this->assertSame('PATCH', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/zones/zone_id/settings/always_use_https', $this->lastRequest()->getUri()->getPath());
        $this->assertSame(['value' => 'on'], json_decode((string) $this->lastRequest()->getBody(), true));
    }

    /**
     * Values are not all strings: TTLs are integers, and a few settings take an
     * object, so whatever is passed has to reach Cloudflare unchanged.
     *
     * @param mixed $value
     */
    #[TestWith(['browser_cache_ttl', 18000])]
    #[TestWith(['min_tls_version', '1.2'])]
    #[TestWith(['aegis', ['enabled' => true, 'pool_id' => 'pool_id']])]
    #[TestWith(['security_level', 'off'])]
    #[Test]
    public function shouldEditAnyValueShape(string $settingId, $value)
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => ['id' => $settingId, 'value' => $value]])),
        ]);

        $response = $client->zones()->settings()->edit('zone_id', $settingId, ['value' => $value]);

        $this->assertTrue($response->successful());
        $this->assertSame("/client/v4/zones/zone_id/settings/{$settingId}", $this->lastRequest()->getUri()->getPath());
        $this->assertSame(['value' => $value], json_decode((string) $this->lastRequest()->getBody(), true));
    }

    /**
     * A handful of settings, `ssl_recommender` among them, take `enabled`
     * instead of `value`.
     */
    #[TestWith([true])]
    #[TestWith([false])]
    #[Test]
    public function shouldEditWithEnabledBody(bool $enabled)
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => ['id' => 'ssl_recommender', 'enabled' => $enabled]])),
        ]);

        $response = $client->zones()->settings()->edit('zone_id', 'ssl_recommender', ['enabled' => $enabled]);

        $this->assertTrue($response->successful());
        $this->assertSame('PATCH', $this->lastRequest()->getMethod());
        $this->assertSame(['enabled' => $enabled], json_decode((string) $this->lastRequest()->getBody(), true));
    }

    /**
     * The body is checked by key, so falsy but meaningful values survive.
     *
     * @param mixed $value
     */
    #[TestWith([['value' => 0]])]
    #[TestWith([['value' => '']])]
    #[TestWith([['enabled' => false]])]
    #[Test]
    public function shouldAcceptFalsyValues(array $values)
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => []])),
        ]);

        $response = $client->zones()->settings()->edit('zone_id', 'browser_cache_ttl', $values);

        $this->assertTrue($response->successful());
        $this->assertSame($values, json_decode((string) $this->lastRequest()->getBody(), true));
    }

    #[TestWith([[]])]
    #[TestWith([['values' => 'on']])]
    #[Test]
    public function shouldThrowWhenBodyHasNeitherValueNorEnabled(array $values)
    {
        $client = $this->mockClient([]);

        $this->expectException(MissingArgumentException::class);

        $client->zones()->settings()->edit('zone_id', 'always_use_https', $values);
    }
}
