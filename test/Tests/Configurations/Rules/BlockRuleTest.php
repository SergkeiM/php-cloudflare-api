<?php

namespace Cloudflare\Tests\Configurations\Rules;

use Cloudflare\Configurations\Rules\BlockRule;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class BlockRuleTest extends TestCase
{
    #[Test]
    public function shouldBuildArray()
    {
        $rule = new BlockRule(['error' => 'blocked'], 'application/json', 403);

        $array = $rule->toArray();

        $this->assertSame('block', $array['action']);
        $this->assertSame([
            'response' => [
                'content' => ['error' => 'blocked'],
                'content_type' => 'application/json',
                'status_code' => 403,
            ],
        ], $array['action_parameters']);
    }
}
