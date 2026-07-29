<?php

namespace Cloudflare\Tests\Endpoints\Organizations;

use Cloudflare\Tests\Concerns\InteractsWithMockClient;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class ProfileTest extends TestCase
{
    use InteractsWithMockClient;

    private function validValues(): array
    {
        return [
            'business_name' => 'Acme Inc',
            'business_email' => 'billing@acme.example',
            'business_phone' => '+15555550100',
            'business_address' => '123 Main St',
            'external_metadata' => '{}',
        ];
    }

    #[Test]
    public function shouldGet()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => ['business_name' => 'Acme Inc']])),
        ]);

        $response = $client->organizations()->profile()->get('organization_id');

        $this->assertTrue($response->successful());
        $this->assertSame('GET', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/organizations/organization_id/profile', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldUpdate()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => ['business_name' => 'Acme Inc']])),
        ]);

        $response = $client->organizations()->profile()->update('organization_id', $this->validValues());

        $this->assertTrue($response->successful());
        $this->assertSame('PUT', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/organizations/organization_id/profile', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldThrowExceptionWhenUpdateParamsAreMissing()
    {
        $client = $this->mockClient([]);

        $this->expectException(\Cloudflare\Exceptions\MissingArgumentException::class);

        $client->organizations()->profile()->update('organization_id', ['business_name' => 'Acme Inc']);
    }
}
