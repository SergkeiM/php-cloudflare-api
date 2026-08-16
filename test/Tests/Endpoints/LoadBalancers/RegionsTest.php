<?php

namespace Cloudflare\Tests\Endpoints\LoadBalancers;

use Cloudflare\Tests\Concerns\InteractsWithMockClient;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\Test;

class RegionsTest extends TestCase
{
    use InteractsWithMockClient;

    #[Test]
    public function shouldListRegions()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode([
                'success' => true,
                'result' => [
                    ['region_code' => 'WNAM'],
                ],
            ])),
        ]);

        $response = $client->loadBalancers()->regions()->list('account_id');

        $this->assertTrue($response->successful());
        $this->assertSame('WNAM', $response->json('result.0.region_code'));

        $this->assertSame('GET', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/accounts/account_id/load_balancers/regions', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldGetRegionDetails()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode([
                'success' => true,
                'result' => [
                    'region_code' => 'WNAM',
                ],
            ])),
        ]);

        $response = $client->loadBalancers()->regions()->get('account_id', 'WNAM');

        $this->assertTrue($response->successful());
        $this->assertSame('WNAM', $response->json('result.region_code'));

        $this->assertSame('GET', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/accounts/account_id/load_balancers/regions/WNAM', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldListFilteredByCountry()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => []])),
        ]);

        $client->loadBalancers()->regions()->list('account_id', ['country_code_a2' => 'US']);

        $this->assertSame('country_code_a2=US', $this->lastRequest()->getUri()->getQuery());
    }
}
