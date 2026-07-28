<?php

namespace Cloudflare\Tests\Endpoints\Accounts;

use Cloudflare\Tests\Concerns\InteractsWithMockClient;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\Test;

class R2EventNotificationsTest extends TestCase
{
    use InteractsWithMockClient;

    #[Test]
    public function shouldReadConfiguration()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode([
                'success' => true,
                'result' => [
                    'bucketName' => 'my-bucket',
                    'queues' => [
                        ['queueId' => 'queue_id'],
                    ],
                ],
            ])),
        ]);

        $response = $client->accounts()->r2EventNotifications()->list('account_id', 'my-bucket');

        $this->assertTrue($response->successful());
        $this->assertSame('queue_id', $response->json('result.queues.0.queueId'));

        $this->assertSame('GET', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/accounts/account_id/event_notifications/r2/my-bucket/configuration', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldGetQueueConfigurationDetails()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode([
                'success' => true,
                'result' => [
                    'queueId' => 'queue_id',
                ],
            ])),
        ]);

        $response = $client->accounts()->r2EventNotifications()->details('account_id', 'my-bucket', 'queue_id');

        $this->assertTrue($response->successful());
        $this->assertSame('queue_id', $response->json('result.queueId'));

        $this->assertSame('GET', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/accounts/account_id/event_notifications/r2/my-bucket/configuration/queues/queue_id', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldCreateConfiguration()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode([
                'success' => true,
                'result' => null,
            ])),
        ]);

        $response = $client->accounts()->r2EventNotifications()->update('account_id', 'my-bucket', 'queue_id', [
            'rules' => [
                ['actions' => ['PutObject']],
            ],
        ]);

        $this->assertTrue($response->successful());

        $this->assertSame('PUT', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/accounts/account_id/event_notifications/r2/my-bucket/configuration/queues/queue_id', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldDeleteConfiguration()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode([
                'success' => true,
                'result' => null,
            ])),
        ]);

        $response = $client->accounts()->r2EventNotifications()->delete('account_id', 'my-bucket', 'queue_id');

        $this->assertTrue($response->successful());

        $this->assertSame('DELETE', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/accounts/account_id/event_notifications/r2/my-bucket/configuration/queues/queue_id', $this->lastRequest()->getUri()->getPath());
    }
}
