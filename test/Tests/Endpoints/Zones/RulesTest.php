<?php

namespace Cloudflare\Tests\Endpoints\Zones;

use Cloudflare\Configurations\Rules\BlockRule;
use Cloudflare\Tests\Concerns\InteractsWithMockClient;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class RulesTest extends TestCase
{
    use InteractsWithMockClient;

    #[Test]
    public function shouldCreateWithArray()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => ['id' => 'rule_id']])),
        ]);

        $response = $client->zones()->rules()->create('zone_id', 'ruleset_id', [
            'action' => 'block',
            'expression' => 'true',
        ]);

        $this->assertTrue($response->successful());
        $this->assertSame('POST', $this->lastRequest()->getMethod());
        $this->assertSame('/client/v4/zones/zone_id/rulesets/ruleset_id/rules', $this->lastRequest()->getUri()->getPath());
    }

    #[Test]
    public function shouldCreateWithRuleObject()
    {
        $client = $this->mockClient([
            new Response(200, [], json_encode(['success' => true, 'result' => ['id' => 'rule_id']])),
        ]);

        $rule = (new BlockRule(['error' => 'blocked']))->enable()->setExpression('true');

        $response = $client->zones()->rules()->create('zone_id', 'ruleset_id', $rule);

        $this->assertTrue($response->successful());
        $this->assertSame('POST', $this->lastRequest()->getMethod());
    }
}
