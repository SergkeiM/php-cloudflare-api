<?php

namespace Cloudflare\Tests\Endpoints\Workers;

use Cloudflare\Configurations\Workers\Deployment;
use Cloudflare\Tests\Concerns\InteractsWithMockClient;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class DeploymentsTest extends TestCase
{
    use InteractsWithMockClient;

    #[Test]
    public function shouldGet()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => [['id' => 'deployment_id']]])),
        ]);

        $response = $client->workers()->deployments()->get('account_id', 'script_name');

        $this->assertTrue($response->successful());
        $this->assertSame('GET', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/accounts/account_id/workers/scripts/script_name/deployments', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldCreateWithArray()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => ['id' => 'deployment_id']])),
        ]);

        $response = $client->workers()->deployments()->create('account_id', 'script_name', [
            'strategy' => 'percentage',
            'versions' => [['version_id' => 'version_id', 'percentage' => 100]],
        ]);

        $this->assertTrue($response->successful());
        $this->assertSame('POST', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/accounts/account_id/workers/scripts/script_name/deployments', $this->lastRequest()->getUri()->getPath());
        $this->assertSame('', $this->lastRequest()->getUri()->getQuery());
    }

    #[Test]
    public function shouldCreateWithDeploymentObjectAndForce()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => ['id' => 'deployment_id']])),
        ]);

        $deployment = (new Deployment('rollout'))->addVersion('version_id', 100);

        $response = $client->workers()->deployments()->create('account_id', 'script_name', $deployment, true);

        $this->assertTrue($response->successful());
        $this->assertSame('POST', $this->lastRequest()->getMethod());
        $this->assertStringContainsString('force=', $this->lastRequest()->getUri()->getQuery());
    }
}
