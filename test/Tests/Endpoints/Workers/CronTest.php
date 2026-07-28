<?php

namespace Cloudflare\Tests\Endpoints\Workers;

use Cloudflare\Tests\Concerns\InteractsWithMockClient;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class CronTest extends TestCase
{
    use InteractsWithMockClient;

    #[Test]
    public function shouldGet()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => [['cron' => '* * * * *']]])),
        ]);

        $response = $client->workers()->cron()->get('account_id', 'script_name');

        $this->assertTrue($response->successful());
        $this->assertSame('GET', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/accounts/account_id/workers/scripts/script_name/schedules', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldUpdate()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => [['cron' => '* * * * *']]])),
        ]);

        $response = $client->workers()->cron()->update('account_id', 'script_name', ['* * * * *', '0 0 * * *']);

        $this->assertTrue($response->successful());
        $this->assertSame('PUT', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/accounts/account_id/workers/scripts/script_name/schedules', $this->lastRequest()->getUri()->getPath());
        $this->assertSame([
            ['cron' => '* * * * *'],
            ['cron' => '0 0 * * *'],
        ], json_decode((string) $this->lastRequest()->getBody(), true));
    }
}
