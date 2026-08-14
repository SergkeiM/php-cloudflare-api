<?php

namespace Cloudflare\Endpoints\Zones;

use Cloudflare\Endpoints\AbstractEndpoint;
use Cloudflare\Contracts\ResponseInterface;
use Cloudflare\Exceptions\MissingArgumentException;

/**
 * Zone settings: the per-zone toggles behind the Cloudflare dashboard, from
 * `always_use_https` and `min_tls_version` to `browser_cache_ttl`.
 *
 * Cloudflare addresses each one by its identifier, and the shape of a value
 * depends on the setting: most take `'on'`/`'off'`, some an integer, and a few
 * an object.
 *
 * @link https://developers.cloudflare.com/api/resources/zones/subresources/settings/
 */
class Settings extends AbstractEndpoint
{
    /**
     * Available settings for a zone, with their current values.
     *
     * @link https://developers.cloudflare.com/api/resources/zones/subresources/settings/methods/list/
     *
     * @param string $zoneId Zone Identifier.
     *
     * @return \Cloudflare\Contracts\ResponseInterface List zone settings response
     */
    public function list(string $zoneId): ResponseInterface
    {
        return $this->getHttpClient()->get("/zones/{$zoneId}/settings");
    }

    /**
     * Fetch a single zone setting by name.
     *
     * @link https://developers.cloudflare.com/api/resources/zones/subresources/settings/methods/get/
     *
     * @param string $zoneId Zone Identifier.
     * @param string $settingId Setting name, e.g. `always_use_https`.
     *
     * @return \Cloudflare\Contracts\ResponseInterface Get zone setting response
     */
    public function get(string $zoneId, string $settingId): ResponseInterface
    {
        return $this->getHttpClient()->get("/zones/{$zoneId}/settings/{$settingId}");
    }

    /**
     * Update a single zone setting by name.
     *
     * Cloudflare accepts one of two bodies, depending on the setting: `value`
     * for nearly all of them, and `enabled` for the handful that take it, such
     * as `ssl_recommender`.
     *
     * ```php
     * $client->zones()->settings()->edit('ZONE_ID', 'always_use_https', ['value' => 'on']);
     * $client->zones()->settings()->edit('ZONE_ID', 'browser_cache_ttl', ['value' => 18000]);
     * $client->zones()->settings()->edit('ZONE_ID', 'ssl_recommender', ['enabled' => true]);
     * ```
     *
     * @link https://developers.cloudflare.com/api/resources/zones/subresources/settings/methods/edit/
     *
     * @param string $zoneId Zone Identifier.
     * @param string $settingId Setting name, e.g. `always_use_https`.
     * @param array $values Setting value: `['value' => mixed]`, or `['enabled' => bool]` for the settings that take it.
     *
     * @throws \Cloudflare\Exceptions\MissingArgumentException
     *
     * @return \Cloudflare\Contracts\ResponseInterface Edit zone setting response
     */
    public function edit(string $zoneId, string $settingId, array $values): ResponseInterface
    {
        // Checked by key rather than by value: `['enabled' => false]` and
        // `['value' => 0]` are both meaningful bodies.
        if (!array_key_exists('value', $values) && !array_key_exists('enabled', $values)) {
            throw new MissingArgumentException(['value', 'enabled']);
        }

        return $this->getHttpClient()->patch("/zones/{$zoneId}/settings/{$settingId}", $values);
    }
}
