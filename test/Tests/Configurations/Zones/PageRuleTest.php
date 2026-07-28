<?php

namespace Cloudflare\Tests\Configurations\Zones;

use Cloudflare\Configurations\Zones\PageRule;
use PHPUnit\Framework\Attributes\Test;

class PageRuleTest extends \PHPUnit\Framework\TestCase
{
    #[Test]
    public function shouldNotHaveActions()
    {
        $pageRule = new PageRule('example.com/*');

        $this->assertEquals([
            'targets' => [
                [
                    'target' => 'url',
                    'constraint' => [
                        'operator' => 'matches',
                        'value' => 'example.com/*'
                    ]
                ]
            ],
            'actions' => []
        ], $pageRule->toArray());
    }

    #[Test]
    public function shouldHaveZarazDisabled()
    {
        $pageRule = (new PageRule('example.com/*'))->disableZaraz(true);

        $this->assertEquals([
            'targets' => [
                [
                    'target' => 'url',
                    'constraint' => [
                        'operator' => 'matches',
                        'value' => 'example.com/*'
                    ]
                ]
            ],
            'actions' => [
                [
                    'id' => 'disable_zaraz',
                    'value' => 'on'
                ]
            ]
        ], $pageRule->toArray());
    }

    public function shouldHaveStatusDisabled()
    {
        $pageRule = (new PageRule('example.com/*'))->disable();

        $this->assertEquals('disabled', $pageRule->toArray()['status']);
    }
}
