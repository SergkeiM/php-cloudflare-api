<?php

namespace Cloudflare\Tests\Endpoints\Accounts;

use Cloudflare\Tests\Concerns\InteractsWithMockClient;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\Test;

class LoadBalancerRegionsTest extends TestCase
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

        $response = $client->accounts()->loadBalancerRegions()->list('account_id');

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

        $response = $client->accounts()->loadBalancerRegions()->details('account_id', 'WNAM');

        $this->assertTrue($response->successful());
        $this->assertSame('WNAM', $response->json('result.region_code'));

        $this->assertSame('GET', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/accounts/account_id/load_balancers/regions/WNAM', $this->lastRequest()->getUri()->getPath());
    }
}
