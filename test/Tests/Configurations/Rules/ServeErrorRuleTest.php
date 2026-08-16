<?php

namespace Cloudflare\Tests\Configurations\Rules;

use Cloudflare\Configurations\Rules\ServeErrorRule;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class ServeErrorRuleTest extends TestCase
{
    #[Test]
    public function shouldBuildArrayWithTheRequiredContentType()
    {
        $rule = new ServeErrorRule('text/html');

        $array = $rule->toArray();

        $this->assertSame('serve_error', $array['action']);
        $this->assertSame(['content_type' => 'text/html'], $array['action_parameters']);
    }

    #[Test]
    public function shouldCarryContentAndStatusCode()
    {
        $rule = new ServeErrorRule('text/html', '<h1>Gone</h1>', 410);

        $this->assertSame([
            'content_type' => 'text/html',
            'content' => '<h1>Gone</h1>',
            'status_code' => 410,
        ], $rule->toArray()['action_parameters']);
    }
}
