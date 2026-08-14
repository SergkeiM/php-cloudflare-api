<?php

namespace Cloudflare\Tests\Endpoints\Rulesets;

use Cloudflare\Exceptions\InvalidArgumentException;
use Cloudflare\Tests\Concerns\InteractsWithMockClient;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class VersionsTest extends TestCase
{
    use InteractsWithMockClient;

    #[Test]
    public function shouldListForZone()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => [['id' => 'ruleset_id', 'version' => '1']]])),
        ]);

        $response = $client->rulesets()->versions()->list(null, 'zone_id', 'ruleset_id');

        $this->assertTrue($response->successful());
        $this->assertSame('GET', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/zones/zone_id/rulesets/ruleset_id/versions', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldListForAccount()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => [['id' => 'ruleset_id', 'version' => '1']]])),
        ]);

        $response = $client->rulesets()->versions()->list('account_id', null, 'ruleset_id');

        $this->assertTrue($response->successful());
        $this->assertSame('/client/v4/accounts/account_id/rulesets/ruleset_id/versions', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldGetDetails()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => ['id' => 'ruleset_id', 'version' => '2']])),
        ]);

        $response = $client->rulesets()->versions()->get(null, 'zone_id', 'ruleset_id', '2');

        $this->assertTrue($response->successful());
        $this->assertSame('GET', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/zones/zone_id/rulesets/ruleset_id/versions/2', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldDelete()
    {
        $client = $this->mockClient([
            new Response(204, [], ''),
        ]);

        $response = $client->rulesets()->versions()->delete('account_id', null, 'ruleset_id', '2');

        $this->assertTrue($response->successful());
        $this->assertSame('DELETE', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/accounts/account_id/rulesets/ruleset_id/versions/2', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldGetRulesByTag()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => ['rules' => [['id' => 'rule_id']]]])),
        ]);

        $response = $client->rulesets()->versions()->byTag(null, 'zone_id', 'ruleset_id', '2', 'wordpress');

        $this->assertTrue($response->successful());
        $this->assertSame('GET', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/zones/zone_id/rulesets/ruleset_id/versions/2/by_tag/wordpress', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldThrowWhenNeitherScopeProvided()
    {
        $client = $this->mockClient([]);

        $this->expectException(InvalidArgumentException::class);

        $client->rulesets()->versions()->list(null, null, 'ruleset_id');
    }
}
