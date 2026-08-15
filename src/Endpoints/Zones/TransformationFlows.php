<?php

namespace Cloudflare\Endpoints\Zones;

use Cloudflare\Endpoints\AbstractEndpoint;
use Cloudflare\Contracts\ResponseInterface;

/**
 * Image transformation flows for a zone.
 *
 * A flow decides how incoming image requests get transformed: either handed to
 * a provider, or matched by a trigger and rewritten with your own
 * transformations. Cloudflare files these under Images, though the endpoints
 * are addressed per zone.
 *
 * @link https://developers.cloudflare.com/images/transform-images/
 */
class TransformationFlows extends AbstractEndpoint
{
    /**
     * Get the transformation flows configured for a zone.
     *
     * The response carries an `etag` — pass it back to `update()` so Cloudflare
     * can reject a write that would clobber someone else's change.
     *
     * @link https://developers.cloudflare.com/images/transform-images/
     *
     * @param string $accountId Account Identifier.
     * @param string $zoneId Zone Identifier.
     *
     * @return ResponseInterface Get transformation flows response
     */
    public function get(string $accountId, string $zoneId): ResponseInterface
    {
        return $this->getHttpClient()->get("/accounts/{$accountId}/zones/{$zoneId}/v1/images/flows");
    }

    /**
     * Replace the transformation flows configured for a zone.
     *
     * This is a full replace, not a merge: the flows you send become the whole
     * configuration. Each flow is one of two shapes —
     *
     * - `['type' => 'provider', 'provider' => 'fastly', 'enabled' => true, 'version' => 1]`
     * - `['type' => 'custom', 'name' => '…', 'enabled' => true, 'trigger' => […], 'transformations' => [['key' => '…', 'value' => '…']]]`
     *
     * A custom flow's `trigger` is itself typed: `path` with `paths`,
     * `extension` with `extensions`, `query-param` with `params`, or `or`
     * combining several `triggers`.
     *
     * ```php
     * $current = $client->zones()->transformationFlows()->get('ACCOUNT_ID', 'ZONE_ID');
     *
     * $client->zones()->transformationFlows()->update('ACCOUNT_ID', 'ZONE_ID', [
     *     [
     *         'type' => 'custom',
     *         'name' => 'Thumbnails',
     *         'enabled' => true,
     *         'trigger' => ['type' => 'path', 'paths' => ['/thumbs/*']],
     *         'transformations' => [['key' => 'width', 'value' => '200']],
     *     ],
     * ], $current->json('result.etag'));
     * ```
     *
     * @link https://developers.cloudflare.com/images/transform-images/
     *
     * @param string $accountId Account Identifier.
     * @param string $zoneId Zone Identifier.
     * @param array $flows The complete list of flows for the zone. An empty list clears them.
     * @param string|null $etag The `etag` from `get()`, to make the write conditional on nothing having changed since.
     * @param int $version Schema version of the request. Cloudflare accepts `2`.
     *
     * @return ResponseInterface Update transformation flows response
     */
    public function update(string $accountId, string $zoneId, array $flows, ?string $etag = null, int $version = 2): ResponseInterface
    {
        $body = [
            'version' => $version,
            'flows' => array_values($flows),
        ];

        if ($etag !== null) {
            $body['etag'] = $etag;
        }

        return $this->getHttpClient()->put("/accounts/{$accountId}/zones/{$zoneId}/v1/images/flows", $body);
    }
}
