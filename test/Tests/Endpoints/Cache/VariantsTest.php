<?php

namespace Cloudflare\Tests\Endpoints\Cache;

use Cloudflare\Exceptions\MissingArgumentException;
use Cloudflare\Tests\Concerns\InteractsWithMockClient;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class VariantsTest extends TestCase
{
    use InteractsWithMockClient;

    private const PATH = '/client/v4/zones/zone_id/cache/variants';

    #[Test]
    public function shouldGetDetails()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => ['id' => 'variants', 'value' => ['jpeg' => ['image/webp']]]])),
        ]);

        $response = $client->cache()->variants()->get('zone_id');

        $this->assertTrue($response->successful());
        $this->assertSame('GET', $this->lastRequest()->getMethod());
        $this->assertSame(self::PATH, $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldEdit()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => ['id' => 'variants']])),
        ]);

        $value = [
            'jpeg' => ['image/webp', 'image/avif'],
            'png' => ['image/webp'],
        ];

        $response = $client->cache()->variants()->edit('zone_id', $value);

        $this->assertTrue($response->successful());
        $this->assertSame('PATCH', $this->lastRequest()->getMethod());
        $this->assertSame(self::PATH, $this->lastRequest()->getUri()->getPath());
        $this->assertSame(['value' => $value], json_decode((string) $this->lastRequest()->getBody(), true));
    }

    #[Test]
    public function shouldThrowWhenEditingWithoutValue()
    {
        $client = $this->mockClient([]);

        $this->expectException(MissingArgumentException::class);

        $client->cache()->variants()->edit('zone_id', []);
    }

    #[Test]
    public function shouldDelete()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => ['id' => 'variants']])),
        ]);

        $response = $client->cache()->variants()->delete('zone_id');

        $this->assertTrue($response->successful());
        $this->assertSame('DELETE', $this->lastRequest()->getMethod());
        $this->assertSame(self::PATH, $this->lastRequest()->getUri()->getPath());
    }
}
