<?php

namespace CloudFlare\Configurations\Zones;

use CloudFlare\Contracts\Configuration;

class CachePurge implements Configuration
{
    private array $options = [];

    /**
     * For more information on cache tags and purging by tags, please refer to purge by cache-tags documentation page.
     *
     * @link https://developers.cloudflare.com/cache/how-to/purge-cache/purge-by-tags/#purge-cache-by-cache-tags-enterprise-only
     *
     * @param array $tags Any assets served with a Cache-tag response header that matches one of the provided values will be purged from the cache. (Enterprise only)
     * @return \CloudFlare\Configurations\Zones\CachePurge
     */
    public function byTags(array $tags): self
    {
        $this->options = [
            'tags' => $tags
        ];

        return $this;
    }

    /**
     * For more information purging by hostnames, please refer to purge by hostname documentation page.
     *
     * @link https://developers.cloudflare.com/cache/how-to/purge-cache/purge-by-hostname/
     *
     * @param array $hosts Any assets at URLs with a host that matches one of the provided values will be purged from the cache. (Enterprise only)
     * @return \CloudFlare\Configurations\Zones\CachePurge
     */
    public function byHosts(array $hosts): self
    {
        $this->options = [
            'hosts' => $hosts
        ];

        return $this;
    }

    /**
     * For more information on purging by prefixes, please refer to purge by prefix documentation page.
     *
     * @link https://developers.cloudflare.com/cache/how-to/purge-cache/purge_by_prefix/
     *
     * @param array $prefixes Any assets in the directory will be purged from cache. (Enterprise only)
     * @return \CloudFlare\Configurations\Zones\CachePurge
     */
    public function byPrefixes(array $prefixes): self
    {
        $this->options = [
            'prefixes' => $prefixes
        ];

        return $this;
    }

    /**
     * For more information on purging files, please refer to purge by single-file documentation page.
     *
     * @link https://developers.cloudflare.com/cache/how-to/purge-cache/purge-by-single-file
     *
     * @param array $files Purges assets in the Cloudflare cache that match the URL(s) exactly, except these single-file purge exclusions
     *
     * @return \CloudFlare\Configurations\Zones\CachePurge
     */
    public function byFiles(array $files): self
    {
        $this->options = [
            'files' => $files
        ];

        return $this;
    }

    /**
     * For more information on purging files with URL and headers, please refer to purge by single-file documentation page.
     *
     * @link https://developers.cloudflare.com/cache/how-to/purge-cache/purge-cache-key/
     *
     * @param string $url Asset URL.
     * @param string $device One of: `mobile`, `tablet`, `desktop`.
     * @param string $country ISO-3166-1 alpha-2 country code.
     * @param string $language
     * @return \CloudFlare\Configurations\Zones\CachePurge
     */
    public function byFilesAdvanced(
        string $url,
        string $device = null,
        string $country = null,
        string $language = null
    ): self {

        $index = false;

        $headers = [];

        if(!is_null($device)) {
            $headers['CF-Device-Type'] = $device;
        }

        if(!is_null($country)) {
            $headers['CF-IPCountry'] = mb_strtoupper($country);
        }

        if(!is_null($language)) {
            $headers['accept-language'] = $language;
        }

        $newValue = [
            'url' => $url,
            'headers' => $headers
        ];

        if(isset($this->options['files']) && !empty($this->options['files'])) {

            $urls = array_column($this->options['files'], 'url');
            $index = array_search($url, $urls);
        }

        if ($index !== false) {
            $this->options['files'][$index] = $newValue;
        } else {
            $this->options['files'][] = $newValue;
        }

        return $this;
    }

    /**
     * For more information, please refer to [purge everything documentation page](https://developers.cloudflare.com/cache/how-to/purge-cache/purge-everything/).
     * @return \CloudFlare\Configurations\Zones\CachePurge
     */
    public function everything(): self
    {
        $this->options = [
            'purge_everything' => true
        ];

        return $this;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return $this->options;
    }
}
