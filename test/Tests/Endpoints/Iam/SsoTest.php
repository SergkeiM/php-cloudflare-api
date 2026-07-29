<?php

namespace Cloudflare\Tests\Endpoints\Iam;

use Cloudflare\Tests\Concerns\InteractsWithMockClient;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class SsoTest extends TestCase
{
    use InteractsWithMockClient;

    #[Test]
    public function shouldList()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => [['id' => 'sso_connector_id']]])),
        ]);

        $response = $client->iam()->sso()->list('account_id');

        $this->assertTrue($response->successful());
        $this->assertSame('GET', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/accounts/account_id/sso_connectors', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldCreate()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => ['id' => 'sso_connector_id']])),
        ]);

        $response = $client->iam()->sso()->create('account_id', ['email_domain' => 'example.com']);

        $this->assertTrue($response->successful());
        $this->assertSame('POST', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/accounts/account_id/sso_connectors', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldThrowExceptionWhenCreateParamsAreMissing()
    {
        $client = $this->mockClient([]);

        $this->expectException(\Cloudflare\Exceptions\MissingArgumentException::class);

        $client->iam()->sso()->create('account_id', []);
    }

    #[Test]
    public function shouldGetDetails()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => ['id' => 'sso_connector_id']])),
        ]);

        $response = $client->iam()->sso()->get('account_id', 'sso_connector_id');

        $this->assertTrue($response->successful());
        $this->assertSame('GET', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/accounts/account_id/sso_connectors/sso_connector_id', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldUpdate()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => ['id' => 'sso_connector_id']])),
        ]);

        $response = $client->iam()->sso()->update('account_id', 'sso_connector_id', ['enabled' => true]);

        $this->assertTrue($response->successful());
        $this->assertSame('PATCH', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/accounts/account_id/sso_connectors/sso_connector_id', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldDelete()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => ['id' => 'sso_connector_id']])),
        ]);

        $response = $client->iam()->sso()->delete('account_id', 'sso_connector_id');

        $this->assertTrue($response->successful());
        $this->assertSame('DELETE', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/accounts/account_id/sso_connectors/sso_connector_id', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldBeginVerification()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => ['id' => 'sso_connector_id']])),
        ]);

        $response = $client->iam()->sso()->beginVerification('account_id', 'sso_connector_id');

        $this->assertTrue($response->successful());
        $this->assertSame('POST', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/accounts/account_id/sso_connectors/sso_connector_id/begin_verification', $this->lastRequest()->getUri()->getPath());
    }
}
