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

    #[Test]
    public function shouldHaveLanguage()
    {
        $cachePurge = (new CachePurge())->byFilesAdvanced('https://example.com/script.js', language: 'en-US');

        $this->assertEquals([
            'files' => [
                [
                    'url' => 'https://example.com/script.js',
                    'headers' => [
                        'accept-language' => 'en-US'
                    ]
                ]
            ]
        ], $cachePurge->toArray());
    }

    #[Test]
    public function shouldOverrideExistingFileAdvancedEntry()
    {
        $cachePurge = (new CachePurge())
            ->byFilesAdvanced('https://example.com/script.js', 'mobile')
            ->byFilesAdvanced('https://example.com/script.js', 'desktop');

        $files = $cachePurge->toArray()['files'];

        $this->assertCount(1, $files);
        $this->assertSame('desktop', $files[0]['headers']['CF-Device-Type']);
    }

    #[Test]
    public function shouldHaveTags()
    {
        $cachePurge = (new CachePurge())->byTags(['my-tag']);

        $this->assertEquals(['tags' => ['my-tag']], $cachePurge->toArray());
    }

    #[Test]
    public function shouldHaveHosts()
    {
        $cachePurge = (new CachePurge())->byHosts(['example.com']);

        $this->assertEquals(['hosts' => ['example.com']], $cachePurge->toArray());
    }

    #[Test]
    public function shouldHavePrefixes()
    {
        $cachePurge = (new CachePurge())->byPrefixes(['images/']);

        $this->assertEquals(['prefixes' => ['images/']], $cachePurge->toArray());
    }

    #[Test]
    public function shouldHaveFiles()
    {
        $cachePurge = (new CachePurge())->byFiles(['https://example.com/script.js']);

        $this->assertEquals(['files' => ['https://example.com/script.js']], $cachePurge->toArray());
    }
}
