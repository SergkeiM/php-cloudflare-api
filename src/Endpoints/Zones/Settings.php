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
 * Settings are read one at a time. Cloudflare deprecated the endpoint returning
 * all of them at once, and published no replacement, so this package does not
 * wrap it — if you still need it, issue the request yourself with
 * `$client->getHttpClient()->get("/zones/{$zoneId}/settings")`.
 *
 * @link https://developers.cloudflare.com/api/resources/zones/subresources/settings/
 */
class Settings extends AbstractEndpoint
{
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

    /**
     * Replace the Origin TLS Compliance Modes setting for a zone.
     *
     * The one setting Cloudflare exposes a full-replace endpoint for: the modes
     * you send become the whole list, and any mode you leave out is removed. An
     * empty list clears the constraint. `fips` and `pqh` are supported today,
     * and Cloudflare may add more, so read the current value before writing if
     * you mean to keep what is already there.
     *
     * ```php
     * $client->zones()->settings()->replaceOriginTlsComplianceModes('ZONE_ID', ['fips']);
     * ```
     *
     * @link https://developers.cloudflare.com/api/resources/zones/subresources/settings/
     *
     * @param string $zoneId Zone Identifier.
     * @param array $modes TLS compliance modes constraining the key-exchange algorithms Cloudflare offers the origin, e.g. `['fips', 'pqh']`.
     *
     * @return \Cloudflare\Contracts\ResponseInterface Replace Origin TLS Compliance Modes response
     */
    public function replaceOriginTlsComplianceModes(string $zoneId, array $modes): ResponseInterface
    {
        return $this->getHttpClient()->put("/zones/{$zoneId}/settings/origin_tls_compliance_modes", [
            'value' => $modes,
        ]);
    }

    /**
     * Delete the Origin TLS Compliance Modes setting for a zone.
     *
     * Removes the compliance constraint entirely, returning the zone to
     * Cloudflare's default of not filtering the key-exchange algorithm list it
     * offers the origin.
     *
     * @link https://developers.cloudflare.com/api/resources/zones/subresources/settings/
     *
     * @param string $zoneId Zone Identifier.
     *
     * @return \Cloudflare\Contracts\ResponseInterface Delete Origin TLS Compliance Modes response
     */
    public function deleteOriginTlsComplianceModes(string $zoneId): ResponseInterface
    {
        return $this->getHttpClient()->delete("/zones/{$zoneId}/settings/origin_tls_compliance_modes");
    }
}
