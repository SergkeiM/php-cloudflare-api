<?php

namespace Cloudflare\Tests\Endpoints\Accounts;

use Cloudflare\Tests\Concerns\InteractsWithMockClient;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\Test;

class LoadBalancerMonitorGroupsTest extends TestCase
{
    use InteractsWithMockClient;

    #[Test]
    public function shouldListMonitorGroups()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode([
                'success' => true,
                'result' => [
                    ['id' => 'monitor_group_id'],
                ],
            ])),
        ]);

        $response = $client->accounts()->loadBalancerMonitorGroups()->list('account_id');

        $this->assertTrue($response->successful());
        $this->assertSame('monitor_group_id', $response->json('result.0.id'));

        $this->assertSame('GET', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/accounts/account_id/load_balancers/monitor_groups', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldCreateMonitorGroup()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode([
                'success' => true,
                'result' => [
                    'id' => 'monitor_group_id',
                ],
            ])),
        ]);

        $response = $client->accounts()->loadBalancerMonitorGroups()->create('account_id', [
            'description' => 'Primary datacenter monitors',
            'members' => [
                ['monitor_id' => 'monitor_id', 'enabled' => true, 'monitoring_only' => false, 'must_be_healthy' => true],
            ],
        ]);

        $this->assertTrue($response->successful());
        $this->assertSame('monitor_group_id', $response->json('result.id'));

        $this->assertSame('POST', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/accounts/account_id/load_balancers/monitor_groups', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldGetMonitorGroupDetails()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode([
                'success' => true,
                'result' => [
                    'id' => 'monitor_group_id',
                ],
            ])),
        ]);

        $response = $client->accounts()->loadBalancerMonitorGroups()->details('account_id', 'monitor_group_id');

        $this->assertTrue($response->successful());
        $this->assertSame('monitor_group_id', $response->json('result.id'));

        $this->assertSame('GET', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/accounts/account_id/load_balancers/monitor_groups/monitor_group_id', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldPatchMonitorGroup()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode([
                'success' => true,
                'result' => [
                    'id' => 'monitor_group_id',
                    'description' => 'Secondary datacenter monitors',
                ],
            ])),
        ]);

        $response = $client->accounts()->loadBalancerMonitorGroups()->patch('account_id', 'monitor_group_id', [
            'description' => 'Secondary datacenter monitors',
        ]);

        $this->assertTrue($response->successful());
        $this->assertSame('Secondary datacenter monitors', $response->json('result.description'));

        $this->assertSame('PATCH', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/accounts/account_id/load_balancers/monitor_groups/monitor_group_id', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldUpdateMonitorGroup()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode([
                'success' => true,
                'result' => [
                    'id' => 'monitor_group_id',
                    'description' => 'Primary datacenter monitors',
                ],
            ])),
        ]);

        $response = $client->accounts()->loadBalancerMonitorGroups()->update('account_id', 'monitor_group_id', [
            'description' => 'Primary datacenter monitors',
            'members' => [
                ['monitor_id' => 'monitor_id', 'enabled' => true, 'monitoring_only' => false, 'must_be_healthy' => true],
            ],
        ]);

        $this->assertTrue($response->successful());
        $this->assertSame('Primary datacenter monitors', $response->json('result.description'));

        $this->assertSame('PUT', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/accounts/account_id/load_balancers/monitor_groups/monitor_group_id', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldDeleteMonitorGroup()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode([
                'success' => true,
                'result' => [
                    'id' => 'monitor_group_id',
                ],
            ])),
        ]);

        $response = $client->accounts()->loadBalancerMonitorGroups()->delete('account_id', 'monitor_group_id');

        $this->assertTrue($response->successful());

        $this->assertSame('DELETE', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/accounts/account_id/load_balancers/monitor_groups/monitor_group_id', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldListMonitorGroupReferences()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode([
                'success' => true,
                'result' => [
                    ['reference_type' => 'referral', 'resource_id' => 'pool_id'],
                ],
            ])),
        ]);

        $response = $client->accounts()->loadBalancerMonitorGroups()->references('account_id', 'monitor_group_id');

        $this->assertTrue($response->successful());
        $this->assertSame('pool_id', $response->json('result.0.resource_id'));

        $this->assertSame('GET', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/accounts/account_id/load_balancers/monitor_groups/monitor_group_id/references', $this->lastRequest()->getUri()->getPath());
    }
}
