<?php

namespace Cloudflare\Tests\Endpoints;

use Cloudflare\Tests\Concerns\InteractsWithMockClient;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class OrganizationsTest extends TestCase
{
    use InteractsWithMockClient;

    #[Test]
    public function shouldList()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => [['id' => 'organization_id']]])),
        ]);

        $response = $client->organizations()->list();

        $this->assertTrue($response->successful());
        $this->assertSame('GET', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/organizations', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldCreate()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => ['id' => 'organization_id']])),
        ]);

        $response = $client->organizations()->create(['name' => 'My Organization']);

        $this->assertTrue($response->successful());
        $this->assertSame('POST', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/organizations', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldThrowExceptionWhenCreateParamsAreMissing()
    {
        $client = $this->mockClient([]);

        $this->expectException(\Cloudflare\Exceptions\MissingArgumentException::class);

        $client->organizations()->create([]);
    }

    #[Test]
    public function shouldGetDetails()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => ['id' => 'organization_id']])),
        ]);

        $response = $client->organizations()->get('organization_id');

        $this->assertTrue($response->successful());
        $this->assertSame('GET', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/organizations/organization_id', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldUpdate()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => ['id' => 'organization_id']])),
        ]);

        $response = $client->organizations()->update('organization_id', ['name' => 'Renamed']);

        $this->assertTrue($response->successful());
        $this->assertSame('PUT', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/organizations/organization_id', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldDelete()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => ['id' => 'organization_id']])),
        ]);

        $response = $client->organizations()->delete('organization_id');

        $this->assertTrue($response->successful());
        $this->assertSame('DELETE', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/organizations/organization_id', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldListAccounts()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode([
                'success' => true,
                'result' => [
                    ['id' => 'account_id', 'name' => 'Production'],
                ],
            ])),
        ]);

        $response = $client->organizations()->accounts('organization_id');

        $this->assertTrue($response->successful());
        $this->assertSame('Production', $response->json('result.0.name'));

        $this->assertSame('GET', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/organizations/organization_id/accounts', $this->lastRequest()->getUri()->getPath());
    }

    /**
     * The dotted filter names are query parameters in their own right, not
     * nested arrays, so they have to survive encoding intact.
     */
    #[Test]
    public function shouldListAccountsWithDottedFilters()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => []])),
        ]);

        $client->organizations()->accounts('organization_id', [
            'name.startsWith' => 'prod',
            'order_by' => 'account_name',
            'direction' => 'desc',
        ]);

        $this->assertSame(
            'name.startsWith=prod&order_by=account_name&direction=desc',
            urldecode($this->lastRequest()->getUri()->getQuery())
        );
    }

    #[Test]
    public function shouldListShares()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode([
                'success' => true,
                'result' => [
                    ['id' => 'share_id', 'status' => 'active'],
                ],
            ])),
        ]);

        $response = $client->organizations()->shares('organization_id', [
            'status' => 'active',
            'kind' => 'sent',
        ]);

        $this->assertTrue($response->successful());
        $this->assertSame('share_id', $response->json('result.0.id'));

        $this->assertSame('GET', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/organizations/organization_id/shares', $this->lastRequest()->getUri()->getPath());
        $this->assertSame('status=active&kind=sent', $this->lastRequest()->getUri()->getQuery());
    }
}
