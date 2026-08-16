<?php

namespace Cloudflare\Tests\Endpoints\Rulesets;

use Cloudflare\Configurations\Ruleset;
use Cloudflare\Configurations\Rules\BlockRule;
use Cloudflare\Exceptions\InvalidArgumentException;
use Cloudflare\Tests\Concerns\InteractsWithMockClient;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class PhasesTest extends TestCase
{
    use InteractsWithMockClient;

    private const PHASE = 'http_request_firewall_custom';

    #[Test]
    public function shouldGetEntrypointForZone()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => ['id' => 'ruleset_id', 'phase' => self::PHASE]])),
        ]);

        $response = $client->rulesets()->phases()->get(null, 'zone_id', self::PHASE);

        $this->assertTrue($response->successful());
        $this->assertSame('GET', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/zones/zone_id/rulesets/phases/' . self::PHASE . '/entrypoint', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldGetEntrypointForAccount()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => ['id' => 'ruleset_id']])),
        ]);

        $response = $client->rulesets()->phases()->get('account_id', null, self::PHASE);

        $this->assertTrue($response->successful());
        $this->assertSame('/client/v4/accounts/account_id/rulesets/phases/' . self::PHASE . '/entrypoint', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldUpdateEntrypointWithArray()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => ['id' => 'ruleset_id']])),
        ]);

        $values = ['rules' => [['action' => 'block', 'expression' => 'true']]];

        $response = $client->rulesets()->phases()->update(null, 'zone_id', self::PHASE, $values);

        $this->assertTrue($response->successful());
        $this->assertSame('PUT', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/zones/zone_id/rulesets/phases/' . self::PHASE . '/entrypoint', $this->lastRequest()->getUri()->getPath());
        $this->assertSame($values, json_decode((string) $this->lastRequest()->getBody(), true));
    }

    /**
     * The URL names the phase, so a ruleset object's own `phase` and `kind`
     * would only contradict it.
     */
    #[Test]
    public function shouldUpdateEntrypointWithRulesetObject()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => ['id' => 'ruleset_id']])),
        ]);

        $ruleset = (new Ruleset('My custom rules'))
            ->zone()
            ->addRule((new BlockRule('{"error": "blocked"}'))->setExpression('true'));

        $response = $client->rulesets()->phases()->update(null, 'zone_id', self::PHASE, $ruleset);

        $body = json_decode((string) $this->lastRequest()->getBody(), true);

        $this->assertTrue($response->successful());
        $this->assertSame('PUT', $this->lastRequest()->getMethod());
        $this->assertArrayHasKey('rules', $body);
        $this->assertArrayNotHasKey('phase', $body);
        $this->assertArrayNotHasKey('kind', $body);
    }

    #[Test]
    public function shouldListEntrypointVersions()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => [['id' => 'ruleset_id', 'version' => '1']]])),
        ]);

        $response = $client->rulesets()->phases()->versions(null, 'zone_id', self::PHASE);

        $this->assertTrue($response->successful());
        $this->assertSame('GET', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/zones/zone_id/rulesets/phases/' . self::PHASE . '/entrypoint/versions', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldGetEntrypointVersion()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => ['id' => 'ruleset_id', 'version' => '3']])),
        ]);

        $response = $client->rulesets()->phases()->version('account_id', null, self::PHASE, '3');

        $this->assertTrue($response->successful());
        $this->assertSame('GET', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/accounts/account_id/rulesets/phases/' . self::PHASE . '/entrypoint/versions/3', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldThrowWhenNeitherScopeProvided()
    {
        $client = $this->mockClient([]);

        $this->expectException(InvalidArgumentException::class);

        $client->rulesets()->phases()->get(null, null, self::PHASE);
    }
}
