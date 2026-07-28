<?php

namespace Cloudflare\Tests\Configurations\Rules;

use Cloudflare\Configurations\Rules\CompressionRule;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class CompressionRuleTest extends TestCase
{
    #[Test]
    public function shouldBuildArray()
    {
        $rule = new CompressionRule('gzip');

        $array = $rule->toArray();

        $this->assertSame('compress_response', $array['action']);
        $this->assertSame(['algorithms' => ['name' => 'gzip']], $array['action_parameters']);
    }
}
