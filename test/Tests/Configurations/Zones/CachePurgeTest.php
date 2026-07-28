<?php

namespace Cloudflare\Tests\Configurations\Zones;

use Cloudflare\Configurations\Zones\CachePurge;
use PHPUnit\Framework\Attributes\Test;

class CachePurgeTest extends \PHPUnit\Framework\TestCase
{
    #[Test]
    public function shouldBeEmpty()
    {
        $cachePurge = new CachePurge();

        $this->assertEquals([], $cachePurge->toArray());
    }

    #[Test]
    public function shouldHavePurgeEverything()
    {
        $cachePurge = (new CachePurge())->everything();

        $this->assertEquals([
            'purge_everything' => true
        ], $cachePurge->toArray());
    }

    #[Test]
    public function shouldHaveDevice()
    {
        $cachePurge = (new CachePurge())->byFilesAdvanced('https://example.com/script.js', 'mobile');

        $this->assertEquals([
            'files' => [
                [
                    'url' => 'https://example.com/script.js',
                    'headers' => [
                        'CF-Device-Type' => 'mobile'
                    ]
                ]
            ]
        ], $cachePurge->toArray());
    }



    #[Test]
    public function shouldHaveCountry()
    {
        $cachePurge = (new CachePurge())->byFilesAdvanced('https://example.com/script.js', country: 'de');

        $this->assertEquals([
            'files' => [
                [
                    'url' => 'https://example.com/script.js',
                    'headers' => [
                        'CF-IPCountry' => 'DE'
                    ]
                ]
            ]
        ], $cachePurge->toArray());
    }
}
