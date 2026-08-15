<?php

namespace Cloudflare\Endpoints;

use Cloudflare\Contracts\ResponseInterface;
use Cloudflare\Exceptions\MissingArgumentException;

/**
 * Google Tag Gateway: proxies Google Tag Manager and Google Analytics requests
 * through your own zone, so they are served first-party rather than from
 * Google's domains.
 */
class GoogleTagGateway extends AbstractEndpoint
{
    /**
     * Get the Google Tag Gateway configuration for a zone.
     *
     * @link https://developers.cloudflare.com/api/resources/google_tag_gateway/subresources/config/methods/get/
     *
     * @param string $zoneId Zone Identifier.
     *
     * @return \Cloudflare\Contracts\ResponseInterface Get Google Tag Gateway configuration response
     */
    public function get(string $zoneId): ResponseInterface
    {
        return $this->getHttpClient()->get("/zones/{$zoneId}/settings/google-tag-gateway/config");
    }

    /**
     * Update the Google Tag Gateway configuration for a zone.
     *
     * ```php
     * $client->googleTagGateway()->update('ZONE_ID', [
     *     'enabled' => true,
     *     'endpoint' => '/analytics',
     *     'hideOriginalIp' => false,
     *     'measurementId' => 'G-XXXXXXXXXX',
     * ]);
     * ```
     *
     * @link https://developers.cloudflare.com/api/resources/google_tag_gateway/subresources/config/methods/update/
     *
     * @param string $zoneId Zone Identifier.
     * @param array $values Configuration: `enabled`, `endpoint`, `hideOriginalIp` and `measurementId` are required, with `setUpTag` optional. `endpoint` is an absolute path with a single alphanumeric segment, e.g. `/analytics`.
     *
     * @throws \Cloudflare\Exceptions\MissingArgumentException
     *
     * @return \Cloudflare\Contracts\ResponseInterface Update Google Tag Gateway configuration response
     */
    public function update(string $zoneId, array $values): ResponseInterface
    {
        // Checked by key: `enabled` and `hideOriginalIp` are booleans, and
        // `false` is a meaningful value for both.
        $required = ['enabled', 'endpoint', 'hideOriginalIp', 'measurementId'];

        foreach ($required as $key) {
            if (!array_key_exists($key, $values)) {
                throw new MissingArgumentException($required);
            }
        }

        return $this->getHttpClient()->put("/zones/{$zoneId}/settings/google-tag-gateway/config", $values);
    }
}
