<?php

namespace Cloudflare\Tests\Endpoints\Accounts;

use Cloudflare\Tests\Concerns\InteractsWithMockClient;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class SubscriptionsTest extends TestCase
{
    use InteractsWithMockClient;

    #[Test]
    public function shouldList()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => [['id' => 'subscription_id']]])),
        ]);

        $response = $client->accounts()->subscriptions()->list('account_id');

        $this->assertTrue($response->successful());
        $this->assertSame('GET', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/accounts/account_id/subscriptions', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldCreate()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => ['id' => 'subscription_id']])),
        ]);

        $response = $client->accounts()->subscriptions()->create('account_id', [
            'frequency' => 'monthly',
        ]);

        $this->assertTrue($response->successful());
        $this->assertSame('POST', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/accounts/account_id/subscriptions', $this->lastRequest()->getUri()->getPath());
        $this->assertSame(['frequency' => 'monthly'], json_decode((string) $this->lastRequest()->getBody(), true));
    }

    #[Test]
    public function shouldUpdate()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => ['id' => 'subscription_id']])),
        ]);

        $response = $client->accounts()->subscriptions()->update('account_id', 'subscription_id', [
            'frequency' => 'yearly',
        ]);

        $this->assertTrue($response->successful());
        $this->assertSame('PUT', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/accounts/account_id/subscriptions/subscription_id', $this->lastRequest()->getUri()->getPath());
        $this->assertSame(['frequency' => 'yearly'], json_decode((string) $this->lastRequest()->getBody(), true));
    }

    #[Test]
    public function shouldDelete()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => ['subscription_id' => 'subscription_id']])),
        ]);

        $response = $client->accounts()->subscriptions()->delete('account_id', 'subscription_id');

        $this->assertTrue($response->successful());
        $this->assertSame('DELETE', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/accounts/account_id/subscriptions/subscription_id', $this->lastRequest()->getUri()->getPath());
    }
}
