<?php

namespace Cloudflare\Tests\Configurations\Zones;

use Cloudflare\Configurations\Zones\PageRule;
use Cloudflare\Exceptions\ConfigurationException;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class PageRuleTest extends TestCase
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
            'id' => 'disable_zaraz',
            'value' => 'on'
        ], $pageRule->toArray()['actions'][0]);
    }

    #[Test]
    public function shouldHaveStatusDisabled()
    {
        $pageRule = (new PageRule('example.com/*'))->disable();

        $this->assertEquals('disabled', $pageRule->toArray()['status']);
    }

    #[Test]
    public function shouldHaveStatusEnabled()
    {
        $pageRule = (new PageRule('example.com/*'))->enable();

        $this->assertEquals('active', $pageRule->toArray()['status']);
    }

    #[Test]
    public function shouldSetPriority()
    {
        $pageRule = (new PageRule('example.com/*'))->setPriority(5);

        $this->assertSame(5, $pageRule->toArray()['priority']);
    }

    #[Test]
    public function shouldSetAllSimpleActions()
    {
        $pageRule = (new PageRule('example.com/*'))
            ->alwaysUseHTTPS(true)
            ->automaticHTTPSRewrites(true)
            ->browserCacheTTL(3600)
            ->browserIntegrityCheck(true)
            ->cacheByDeviceType(true)
            ->cacheKey('custom-key')
            ->disablePerformance(true)
            ->emailObfuscation(true)
            ->hostHeaderOverride('example.com')
            ->IPGeoLocationHeader(true)
            ->mirage(true)
            ->opportunisticEncryption(true)
            ->originCacheControl(true)
            ->disableSecurity(true)
            ->originErrorPagePassthru(true)
            ->queryStringSort(true)
            ->resolveOverride('origin.example.com')
            ->respectStrongEtag(true)
            ->responseBuffering(true)
            ->rocketLoader(true)
            ->trueClientIpHeader(true)
            ->waf(true);

        $ids = array_column($pageRule->toArray()['actions'], 'id');

        $this->assertSame([
            'always_use_https',
            'automatic_https_rewrites',
            'browser_cache_ttl',
            'browser_check',
            'cache_by_device_type',
            'cache_key',
            'disable_performance',
            'disable_security',
            'host_header_override',
            'ip_geolocation',
            'mirage',
            'opportunistic_encryption',
            'explicit_cache_control',
            'origin_error_page_pass_thru',
            'sort_query_string_for_cache',
            'resolve_override',
            'respect_strong_etag',
            'response_buffering',
            'rocket_loader',
            'true_client_ip_header',
            'waf',
        ], $ids);
    }

    #[Test]
    public function shouldOverrideExistingActionValue()
    {
        $pageRule = (new PageRule('example.com/*'))
            ->browserCacheTTL(3600)
            ->browserCacheTTL(7200);

        $actions = $pageRule->toArray()['actions'];

        $this->assertCount(1, $actions);
        $this->assertSame(7200, $actions[0]['value']);
    }

    #[Test]
    public function shouldSetBypassCacheOnCookie()
    {
        $pageRule = (new PageRule('example.com/*'))->bypassCacheOnCookie('session_*');

        $this->assertSame('bypass_cache_on_cookie', $pageRule->toArray()['actions'][0]['id']);
    }

    #[Test]
    public function shouldThrowOnInvalidBypassCacheOnCookie()
    {
        $this->expectException(ConfigurationException::class);

        (new PageRule('example.com/*'))->bypassCacheOnCookie('invalid cookie!');
    }

    #[Test]
    public function shouldSetCacheOnCookie()
    {
        $pageRule = (new PageRule('example.com/*'))->cacheOnCookie('session_*');

        $this->assertSame('cache_on_cookie', $pageRule->toArray()['actions'][0]['id']);
    }

    #[Test]
    public function shouldThrowOnInvalidCacheOnCookie()
    {
        $this->expectException(ConfigurationException::class);

        (new PageRule('example.com/*'))->cacheOnCookie('invalid cookie!');
    }

    #[Test]
    public function shouldSetValidCacheLevel()
    {
        $pageRule = (new PageRule('example.com/*'))->cacheLevel('aggressive');

        $this->assertSame('cache_level', $pageRule->toArray()['actions'][0]['id']);
    }

    #[Test]
    public function shouldThrowOnInvalidCacheLevel()
    {
        $this->expectException(ConfigurationException::class);

        (new PageRule('example.com/*'))->cacheLevel('invalid');
    }

    #[Test]
    public function shouldSetEdgeCacheTTL()
    {
        $pageRule = (new PageRule('example.com/*'))->edgeCacheTTL(3600);

        $this->assertSame('edge_cache_ttl', $pageRule->toArray()['actions'][0]['id']);
    }

    #[Test]
    public function shouldThrowOnEdgeCacheTTLTooHigh()
    {
        $this->expectException(ConfigurationException::class);

        (new PageRule('example.com/*'))->edgeCacheTTL(2678401);
    }

    #[Test]
    public function shouldSetForwardingURLWithDefaultStatusCode()
    {
        $pageRule = (new PageRule('example.com/*'))->forwardingURL('https://example.com');

        $action = $pageRule->toArray()['actions'][0];
        $this->assertSame('forwarding_url', $action['id']);
        $this->assertSame(301, $action['value']['status_code']);
    }

    #[Test]
    public function shouldThrowOnInvalidForwardingURLStatusCode()
    {
        $this->expectException(ConfigurationException::class);

        (new PageRule('example.com/*'))->forwardingURL('https://example.com', 300);
    }

    #[Test]
    public function shouldSetValidSslMode()
    {
        $pageRule = (new PageRule('example.com/*'))->ssl('full');

        $this->assertSame('ssl', $pageRule->toArray()['actions'][0]['id']);
    }

    #[Test]
    public function shouldThrowOnInvalidSslMode()
    {
        $this->expectException(ConfigurationException::class);

        (new PageRule('example.com/*'))->ssl('invalid');
    }
}
