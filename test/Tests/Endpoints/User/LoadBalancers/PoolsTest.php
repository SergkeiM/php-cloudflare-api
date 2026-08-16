<?php

namespace Cloudflare\Tests\Endpoints\User\LoadBalancers;

use Cloudflare\Exceptions\MissingArgumentException;
use Cloudflare\Tests\Concerns\InteractsWithMockClient;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\Test;

class PoolsTest extends TestCase
{
    use InteractsWithMockClient;

    private function ok(array $result = []): Response
    {
        return new Response(200, [], json_encode(['success' => true, 'result' => $result]));
    }

    /**
     * @return array
     */
    private function pool(): array
    {
        return [
            'name' => 'primary',
            'origins' => [
                ['name' => 'origin', 'address' => '198.51.100.4', 'enabled' => true],
            ],
        ];
    }

    #[Test]
    public function shouldListPools()
    {
        $client = $this->mockClient([$this->ok([['id' => 'pool_id']])]);

        $response = $client->user()->loadBalancers()->pools()->list();

        $this->assertTrue($response->successful());
        $this->assertSame('pool_id', $response->json('result.0.id'));

        $this->assertSame('GET', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/user/load_balancers/pools', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldCreatePool()
    {
        $client = $this->mockClient([$this->ok(['id' => 'pool_id'])]);

        $response = $client->user()->loadBalancers()->pools()->create($this->pool());

        $this->assertTrue($response->successful());

        $this->assertSame('POST', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/user/load_balancers/pools', $this->lastRequest()->getUri()->getPath());
        $this->assertSame($this->pool(), json_decode((string) $this->lastRequest()->getBody(), true));
    }

    #[Test]
    public function shouldThrowWhenCreatingWithoutNameOrOrigins()
    {
        $client = $this->mockClient([]);

        $this->expectException(MissingArgumentException::class);

        $client->user()->loadBalancers()->pools()->create(['name' => 'primary']);
    }

    #[Test]
    public function shouldGetPool()
    {
        $client = $this->mockClient([$this->ok(['id' => 'pool_id'])]);

        $response = $client->user()->loadBalancers()->pools()->get('pool_id');

        $this->assertTrue($response->successful());

        $this->assertSame('GET', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/user/load_balancers/pools/pool_id', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldUpdatePool()
    {
        $client = $this->mockClient([$this->ok(['id' => 'pool_id'])]);

        $response = $client->user()->loadBalancers()->pools()->update('pool_id', $this->pool());

        $this->assertTrue($response->successful());

        $this->assertSame('PUT', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/user/load_balancers/pools/pool_id', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldThrowWhenUpdatingWithoutNameOrOrigins()
    {
        $client = $this->mockClient([]);

        $this->expectException(MissingArgumentException::class);

        $client->user()->loadBalancers()->pools()->update('pool_id', ['name' => 'primary']);
    }

    #[Test]
    public function shouldEditPool()
    {
        $client = $this->mockClient([$this->ok(['id' => 'pool_id'])]);

        $response = $client->user()->loadBalancers()->pools()->edit('pool_id', ['enabled' => false]);

        $this->assertTrue($response->successful());

        $this->assertSame('PATCH', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/user/load_balancers/pools/pool_id', $this->lastRequest()->getUri()->getPath());
    }

    /**
     * The bulk patch hits the collection rather than a single pool.
     */
    #[Test]
    public function shouldBulkEditPools()
    {
        $client = $this->mockClient([$this->ok([['id' => 'pool_id']])]);

        $response = $client->user()->loadBalancers()->pools()->bulkEdit([
            'notification_email' => 'ops@example.com',
        ]);

        $this->assertTrue($response->successful());

        $this->assertSame('PATCH', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/user/load_balancers/pools', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldDeletePool()
    {
        $client = $this->mockClient([$this->ok()]);

        $response = $client->user()->loadBalancers()->pools()->delete('pool_id');

        $this->assertTrue($response->successful());

        $this->assertSame('DELETE', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/user/load_balancers/pools/pool_id', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldGetPoolHealth()
    {
        $client = $this->mockClient([$this->ok(['healthy' => true])]);

        $response = $client->user()->loadBalancers()->pools()->health('pool_id');

        $this->assertTrue($response->successful());

        $this->assertSame('GET', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/user/load_balancers/pools/pool_id/health', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldPreviewPool()
    {
        $client = $this->mockClient([$this->ok(['preview_id' => 'preview_id'])]);

        $response = $client->user()->loadBalancers()->pools()->preview('pool_id', ['path' => '/health']);

        $this->assertTrue($response->successful());

        $this->assertSame('POST', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/user/load_balancers/pools/pool_id/preview', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldListPoolReferences()
    {
        $client = $this->mockClient([$this->ok([['reference_type' => 'referrer']])]);

        $response = $client->user()->loadBalancers()->pools()->references('pool_id');

        $this->assertTrue($response->successful());

        $this->assertSame('GET', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/user/load_balancers/pools/pool_id/references', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldListFilteredByMonitor()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => []])),
        ]);

        $client->user()->loadBalancers()->pools()->list(['monitor' => 'monitor_id']);

        $this->assertSame('monitor=monitor_id', $this->lastRequest()->getUri()->getQuery());
    }
}
