<?php

namespace Cloudflare\Tests\Endpoints\Accounts;

use Cloudflare\Exceptions\MissingArgumentException;
use Cloudflare\Tests\Concerns\InteractsWithMockClient;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\Test;

class SettingsTest extends TestCase
{
    use InteractsWithMockClient;

    #[Test]
    public function shouldListTransformations()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode([
                'success' => true,
                'result' => [
                    ['zone_id' => 'zone_id', 'value' => 'on'],
                ],
            ])),
        ]);

        $response = $client->accounts()->settings()->transformations('account_id');

        $this->assertTrue($response->successful());
        $this->assertSame('on', $response->json('result.0.value'));

        $this->assertSame('GET', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/accounts/account_id/settings/transformations', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldGetUniqueTransformationsBilling()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode([
                'success' => true,
                'result' => ['value' => 'off'],
            ])),
        ]);

        $response = $client->accounts()->settings()->uniqueTransformationsBilling('account_id');

        $this->assertTrue($response->successful());
        $this->assertSame('off', $response->json('result.value'));

        $this->assertSame('GET', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/accounts/account_id/settings/ut-billing', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldEnableUniqueTransformationsBilling()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode([
                'success' => true,
                'result' => ['value' => 'on'],
            ])),
        ]);

        $response = $client->accounts()->settings()->updateUniqueTransformationsBilling('account_id');

        $this->assertTrue($response->successful());
        $this->assertSame('on', $response->json('result.value'));

        $this->assertSame('PATCH', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/accounts/account_id/settings/ut-billing', $this->lastRequest()->getUri()->getPath());
        $this->assertSame(['value' => 'on'], json_decode((string) $this->lastRequest()->getBody(), true));
    }

    #[Test]
    public function shouldThrowWhenBillingValueIsMissing()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true])),
        ]);

        $this->expectException(MissingArgumentException::class);

        $client->accounts()->settings()->updateUniqueTransformationsBilling('account_id', []);
    }
}
