<?php

namespace Cloudflare\Tests\Endpoints\User;

use Cloudflare\Tests\Concerns\InteractsWithMockClient;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\Test;

class CommunicationPreferencesTest extends TestCase
{
    use InteractsWithMockClient;

    #[Test]
    public function shouldGetPreferences()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode([
                'success' => true,
                'result' => [
                    'email_verified' => true,
                    'language-locale' => 'en-US',
                ],
            ])),
        ]);

        $response = $client->user()->communicationPreferences()->get();

        $this->assertTrue($response->successful());
        $this->assertSame('en-US', $response->json('result.language-locale'));

        $this->assertSame('GET', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/user/communication_preferences', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldUpdatePreferences()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode([
                'success' => true,
                'result' => ['language-locale' => 'de-DE'],
            ])),
        ]);

        $values = [
            'preferences' => ['marketing' => true],
            'language-locale' => 'de-DE',
        ];

        $response = $client->user()->communicationPreferences()->update($values);

        $this->assertTrue($response->successful());

        $this->assertSame('PUT', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/user/communication_preferences', $this->lastRequest()->getUri()->getPath());
        $this->assertSame($values, json_decode((string) $this->lastRequest()->getBody(), true));
    }
}
