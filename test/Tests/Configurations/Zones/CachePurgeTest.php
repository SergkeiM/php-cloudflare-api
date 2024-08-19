<?php

namespace CloudFlare\Tests\Configurations\Zones;

use CloudFlare\Configurations\Zones\CachePurge;

class CachePurgeTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @test
     */
    public function shouldBeEmpty()
    {
        $cachePurge = new CachePurge();

        $this->assertEquals([], $cachePurge->toArray());
    }

    /**
     * @test
     */
    public function shouldHavePurgeEverything()
    {
        $cachePurge = (new CachePurge())->everything();

        $this->assertEquals([
            'purge_everything' => true
        ], $cachePurge->toArray());
    }

    /**
     * @test
     */
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

    

    /**
     * @test
     */
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