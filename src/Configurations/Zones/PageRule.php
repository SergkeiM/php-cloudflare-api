<?php

namespace Cloudflare\Configurations\Zones;

use Cloudflare\Exceptions\ConfigurationException;
use Cloudflare\Contracts\Configuration;

class PageRule implements Configuration
{
    /**
     * The set of actions to perform if the targets of this rule match the request. Actions can redirect to another URL or override settings, but not both.
     */
    private array $actions = [];

    /**
     * The priority of the rule, used to define which Page Rule is processed over another. A higher number indicates a higher priority. For example, if you have a catch-all Page Rule (rule A: /images/*) but want a more specific Page Rule to take precedence (rule B: /images/special/*), specify a higher priority for rule B so it overrides rule A.
     */
    private ?int $priority = null;

    /**
     * The status of the Page Rule.
     */
    private ?bool $status = null;

    /**
     * @param string $target A target based on the URL of the request.
     */
    public function __construct(
        private string $target
    ) {

    }

    /**
     * Enable Page Rule.
     * @param bool $status
     * @return \Cloudflare\Configurations\PageRule
     */
    public function enable(): self
    {
        $this->setStatus(true);

        return $this;
    }

    /**
     * Disable Page Rule.
     * @return \Cloudflare\Configurations\PageRule
     */
    public function disable(): self
    {
        $this->setStatus(true);

        return $this;
    }

    /**
     * The status of the Page Rule.
     * @param bool $status
     * @return \Cloudflare\Configurations\PageRule
     */
    public function setStatus(bool $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function setPriority(int $priority): self
    {
        $this->priority = $priority;

        return $this;
    }

    /**
     * Enable Always Use HTTPS feature. If enabled, any http:// URL is converted to https:// through a 301 redirect.
     * If this option does not appear, you do not have an active Edge Certificate.
     * @param bool $value
     * @return \Cloudflare\Configurations\PageRule
     */
    public function alwaysUseHTTPS(bool $value): self
    {
        return $this->addAction('always_use_https', $value);
    }

    /**
     * Turn on or off Automatic HTTPS Rewrites.
     * @param bool $value
     * @return \Cloudflare\Configurations\PageRule
     */
    public function automaticHTTPSRewrites(bool $value): self
    {
        return $this->addAction('automatic_https_rewrites', $value);
    }

    /**
     * Control how long resources cached by client browsers remain valid. The Cloudflare dashboard and the API both prohibit setting Browser Cache TTL to 0 for non-Enterprise domains.
     * @param int $ttl
     * @return \Cloudflare\Configurations\PageRule
     */
    public function browserCacheTTL(int $ttl): self
    {
        return $this->addAction('browser_cache_ttl', $ttl);
    }

    /**
     * Inspect the visitor's browser for headers commonly associated with spammers and certain bots.
     * @param bool $value
     * @return \Cloudflare\Configurations\PageRule
     */
    public function browserIntegrityCheck(bool $value): self
    {
        return $this->addAction('browser_check', $value);
    }

    /**
     * Bypass Cache on Cookie
     * @param string $value
     * @throws \Cloudflare\Exceptions\ConfigurationException
     * @return \Cloudflare\Configurations\PageRule
     */
    public function bypassCacheOnCookie(string $value): self
    {
        if (preg_match('/^([a-zA-Z0-9\.=|_*-]+)$/i', $value) < 1) {
            throw new ConfigurationException('Invalid cookie string.');
        }

        return $this->addAction('bypass_cache_on_cookie', $value);
    }

    /**
     * Separate cached content based on the visitor’s device type.
     * @param bool $value
     * @return \Cloudflare\Configurations\PageRule
     */
    public function cacheByDeviceType(bool $value): self
    {
        return $this->addAction('cache_by_device_type', $value);
    }

    /**
     * Also referred to as Custom Cache Key.
     * Control specifically what variables to include when deciding which resources to cache. This allows customers to determine what to cache based on something other than just the URL.
     * @param string $value
     * @return \Cloudflare\Configurations\PageRule
     */
    public function cacheKey(string $value): self
    {
        return $this->addAction('cache_key', $value);
    }

    /**
     * Apply custom caching based on the option selected:
     * - **bypass**: Bypass. Cloudflare does not cache.
     * - **basic**: No Query String. Delivers resources from cache when there is no query string.
     * - **simplified**: Ignore Query String. Delivers the same resource to everyone independent of the query string.
     * - **aggressive**: Standard. Caches all static content that has a query string.
     * - **cache_everything**: Treats all content as static and caches all file types beyond the [Cloudflare default cached content](https://developers.cloudflare.com/cache/concepts/default-cache-behavior/#default-cached-file-extensions). Respects cache headers from the origin web server unless Edge Cache TTL is also set in the Page Rule. When combined with an Edge Cache TTL > 0, Cache Everything removes cookies from the origin web server response.
     * @param string $value
     * @throws \Cloudflare\Exceptions\ConfigurationException
     * @return \Cloudflare\Configurations\PageRule
     */
    public function cacheLevel(string $value): self
    {
        if (!in_array($value, ['bypass', 'basic', 'simplified', 'aggressive', 'cache_everything'])) {
            throw new ConfigurationException('Invalid cache level');
        }

        return $this->addAction('cache_level', $value);
    }

    /**
     * Apply the Cache Everything option (Cache Level setting) based on a regular expression match against a cookie name.
     * If you add both this setting and Bypass Cache on Cookie to the same page rule, Cache On Cookie takes precedence over Bypass Cache on Cookie.
     * @param string $value
     * @throws \Cloudflare\Exceptions\ConfigurationException
     * @return \Cloudflare\Configurations\PageRule
     */
    public function cacheOnCookie(string $value): self
    {
        if (preg_match('/^([a-zA-Z0-9\.=|_*-]+)$/i', $value) < 1) {
            throw new ConfigurationException('Invalid cookie string.');
        }

        return $this->addAction('cache_on_cookie', $value);
    }

    /**
     * Turn off all active Cloudflare Apps (deprecated).
     * @deprecated
     * @param bool $value
     * @return \Cloudflare\Configurations\PageRule
     */
    public function disableApps(bool $value): self
    {
        return $this->addAction('disable_apps', $value);
    }

    /**
     * Turn off Rocket Loader, Mirage, and Polish.
     * @param bool $value
     * @return \Cloudflare\Configurations\PageRule
     */
    public function disablePerformance(bool $value): self
    {
        return $this->addAction('disable_performance', $value);
    }

    /**
     * Turn off Zaraz.
     * @param bool $value
     * @return \Cloudflare\Configurations\PageRule
     */
    public function disableZaraz(bool $value): self
    {
        return $this->addAction('disable_zaraz', $value);
    }

    /**
     * Specify how long to cache a resource in the Cloudflare global network. Edge Cache TTL is not visible in response headers.
     * @param int $ttl
     * @throws \Cloudflare\Exceptions\ConfigurationException
     * @return \Cloudflare\Configurations\PageRule
     */
    public function edgeCacheTTL(int $ttl): self
    {
        if ($ttl > 2678400) {
            throw new ConfigurationException('Edge Cache TTL too high.');
        }

        return $this->addAction('edge_cache_ttl', $ttl);
    }

    /**
     * Turn on or off Email Obfuscation.
     * @param bool $value
     * @return \Cloudflare\Configurations\PageRule
     */
    public function emailObfuscation(bool $value): self
    {
        return $this->addAction('disable_security', $value);
    }

    /**
     * Redirects one URL to another using an HTTP 301/302 redirect. Refer to Wildcard matching and referencing.
     * @param string $forwardingUrl
     * @param int $statusCode
     * @throws \Cloudflare\Exceptions\ConfigurationException
     * @return \Cloudflare\Configurations\PageRule
     */
    public function forwardingURL(string $forwardingUrl, int $statusCode = 301): self
    {
        if (!in_array($statusCode, ['301', '302'])) {
            throw new ConfigurationException('Status Codes can only be 301 or 302.');
        }

        return $this->addAction("forwarding_url", [
            'status_code' => $statusCode,
            'url' => $forwardingUrl,
        ]);
    }

    /**
     * 	Apply a specific host header.
     * @param string $value
     * @return \Cloudflare\Configurations\PageRule
     */
    public function hostHeaderOverride(string $value): self
    {
        return $this->addAction('host_header_override', $value);
    }

    /**
     * 	Cloudflare adds a CF-IPCountry HTTP header containing the country code that corresponds to the visitor.
     * @param bool $value
     * @return \Cloudflare\Configurations\PageRule
     */
    public function IPGeoLocationHeader(bool $value): self
    {
        return $this->addAction('ip_geolocation', $value);
    }

    /**
     * Turn on or off Mirage.
     * @param bool $value
     * @return \Cloudflare\Configurations\PageRule
     */
    public function mirage(bool $value): self
    {
        return $this->addAction('mirage', $value);
    }

    /**
     * Turn on or off the Opportunistic Encryption.
     * @param bool $value
     * @return \Cloudflare\Configurations\PageRule
     */
    public function opportunisticEncryption(bool $value): self
    {
        return $this->addAction('opportunistic_encryption', $value);
    }

    /**
     * Origin Cache Control is enabled by default for Free, Pro, and Business domains and disabled by default for Enterprise domains.
     * @param bool $value
     * @return \Cloudflare\Configurations\PageRule
     */
    public function originCacheControl(bool $value): self
    {
        return $this->addAction('explicit_cache_control', $value);
    }

    /**
     * 	Turn off Email Obfuscation, Rate Limiting (previous version, deprecated), Scrape Shield, URL (Zone) Lockdown, and WAF managed rules (previous version, deprecated).
     * @param bool $value
     * @return \Cloudflare\Configurations\PageRule
     */
    public function disableSecurity(bool $value): self
    {
        return $this->addAction('disable_security', $value);
    }

    /**
     * Turn on or off Cloudflare error pages generated from issues sent from the origin server. If enabled, this setting triggers error pages issued by the origin.
     * @param bool $value
     * @return \Cloudflare\Configurations\PageRule
     */
    public function originErrorPagePassthru(bool $value): self
    {
        return $this->addAction('origin_error_page_pass_thru', $value);
    }

    /**
     * Turn on or off the reordering of query strings. When query strings have the same structure, caching improves.
     * @param bool $value
     * @return \Cloudflare\Configurations\PageRule
     */
    public function queryStringSort(bool $value): self
    {
        return $this->addAction('sort_query_string_for_cache', $value);
    }

    /**
     * Change the origin address to the value specified in this setting.
     * @param string $value
     * @return \Cloudflare\Configurations\PageRule
     */
    public function resolveOverride(string $value): self
    {
        return $this->addAction('resolve_override', $value);
    }

    /**
     * 	Turn on or off byte-for-byte equivalency checks between the Cloudflare cache and the origin server.
     * @param bool $value
     * @return \Cloudflare\Configurations\PageRule
     */
    public function respectStrongEtag(bool $value): self
    {
        return $this->addAction('respect_strong_etag', $value);
    }

    /**
     * Turn on or off whether Cloudflare should wait for an entire file from the origin server before forwarding it to the site visitor. By default, Cloudflare sends packets to the client as they arrive from the origin server
     * @param bool $value
     * @return \Cloudflare\Configurations\PageRule
     */
    public function responseBuffering(bool $value): self
    {
        return $this->addAction('response_buffering', $value);
    }

    /**
     * Turn on or off Rocket Loader in the Cloudflare Speed app.
     * @param bool $value
     * @return \Cloudflare\Configurations\PageRule
     */
    public function rocketLoader(bool $value): self
    {
        return $this->addAction('rocket_loader', $value);
    }

    /**
     * Control options for the SSL feature of the Edge Certificates tab in the Cloudflare SSL/TLS app.
     * @param string $value
     * @throws \Cloudflare\Exceptions\ConfigurationException
     * @return \Cloudflare\Configurations\PageRule
     */
    public function ssl(string $value): self
    {
        if (!in_array($value, ['off', 'flexible', 'full', 'strict', 'origin_pull'])) {
            throw new ConfigurationException('Can only be set to off, flexible, full, strict, origin_pull.');
        }

        return $this->addAction('ssl', $value);
    }

    /**
     * Turn on or off the True-Client-IP Header feature of the Cloudflare Network app.
     * @param bool $value
     * @return \Cloudflare\Configurations\PageRule
     */
    public function trueClientIpHeader(bool $value): self
    {
        return $this->addAction('true_client_ip_header', $value);
    }

    /**
     * Turn on or off WAF managed rules (previous version, deprecated).
     * You cannot enable or disable individual WAF managed rules via Page Rules.
     * @param bool $value
     * @return \Cloudflare\Configurations\PageRule
     */
    public function waf(bool $value): self
    {
        return $this->addAction('waf', $value);
    }

    /**
     * addAction
     * @param string $id
     * @param mixed $value
     * @return \Cloudflare\Configurations\PageRule
     */
    private function addAction(string $id, mixed $value): self
    {
        $ids = array_column($this->actions, 'id');
        $index = array_search($id, $ids);

        $newValue = [
            'id' => $id,
            'value' => $this->transformValue($value)
        ];

        if ($index !== false) {
            // Override the existing action value with new value.
            $this->actions[$index] = $newValue;
        } else {
            // Add the new action because doesn't exists
            $this->actions[] = $newValue;
        }

        return $this;
    }

    /**
     * Transform value if boolean.
     * @param mixed $value
     * @return mixed
     */
    private function transformValue(mixed $value): mixed
    {

        if(is_bool($value)) {
            return $value === true ? 'on' : 'off';
        }

        return $value;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        $options = [
            'targets' => [
                [
                    'target' => 'url',
                    'constraint' => [
                        'operator' => 'matches',
                        'value' => $this->target
                    ]
                ]
            ],
            'actions' => $this->actions
        ];

        if (!is_null($this->status)) {
            $options['status'] = $this->status == true ? 'active' : 'disabled';
        }

        if (!is_null($this->priority)) {
            $options['priority'] = $this->priority;
        }

        return $options;
    }
}
