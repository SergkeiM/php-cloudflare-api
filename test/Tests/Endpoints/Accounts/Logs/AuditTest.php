<?php

namespace Cloudflare\Tests\Endpoints\Accounts\Logs;

use Cloudflare\Tests\Concerns\InteractsWithMockClient;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class AuditTest extends TestCase
{
    use InteractsWithMockClient;

    #[Test]
    public function shouldList()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => [['id' => 'audit_log_id']]])),
        ]);

        $response = $client->accounts()->logs()->audit()->list('account_id', [
            'since' => '2024-10-30',
            'before' => '2024-10-31',
        ]);

        $this->assertTrue($response->successful());
        $this->assertSame('GET', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/accounts/account_id/logs/audit', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldThrowExceptionWhenListParamsAreMissing()
    {
        $client = $this->mockClient([]);

        $this->expectException(\Cloudflare\Exceptions\MissingArgumentException::class);

        $client->accounts()->logs()->audit()->list('account_id');
    }

    #[Test]
    public function shouldGetHistory()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => [['id' => 'audit_log_id']]])),
        ]);

        $response = $client->accounts()->logs()->audit()->history('account_id', 'audit_log_id', [
            'action_time' => '2024-10-30T15:00:00Z',
            'since' => '2024-10-30',
            'before' => '2024-10-31',
        ]);

        $this->assertTrue($response->successful());
        $this->assertSame('GET', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/accounts/account_id/logs/audit/audit_log_id/history', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldListProductCategories()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => [['product' => 'access']]])),
        ]);

        $response = $client->accounts()->logs()->audit()->productCategories('account_id');

        $this->assertTrue($response->successful());
        $this->assertSame('GET', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/accounts/account_id/logs/audit/product_categories', $this->lastRequest()->getUri()->getPath());
    }
}
