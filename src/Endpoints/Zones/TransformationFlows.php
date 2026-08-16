<?php

namespace Cloudflare\Endpoints\Zones;

use Cloudflare\Endpoints\AbstractEndpoint;
use Cloudflare\Contracts\ResponseInterface;
use Cloudflare\Exceptions\MissingArgumentException;

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
     *     'flows' => [
     *         [
     *             'type' => 'custom',
     *             'name' => 'Thumbnails',
     *             'enabled' => true,
     *             'trigger' => ['type' => 'path', 'paths' => ['/thumbs/*']],
     *             'transformations' => [['key' => 'width', 'value' => '200']],
     *         ],
     *     ],
     *     'etag' => $current->json('result.etag'),
     * ]);
     * ```
     *
     * @link https://developers.cloudflare.com/images/transform-images/
     *
     * @param string $accountId Account Identifier.
     * @param string $zoneId Zone Identifier.
     * @param array $values `flows` is required and replaces the whole configuration; an empty list clears it. `etag` from `get()` makes the write conditional on nothing having changed since. `version` is the request's schema version, defaulting to the `2` Cloudflare accepts.
     *
     * @throws \Cloudflare\Exceptions\MissingArgumentException
     *
     * @return ResponseInterface Update transformation flows response
     */
    public function update(string $accountId, string $zoneId, array $values): ResponseInterface
    {
        if (!array_key_exists('flows', $values)) {
            throw new MissingArgumentException(['flows']);
        }

        $values['version'] ??= 2;
        $values['flows'] = array_values($values['flows']);

        return $this->getHttpClient()->put("/accounts/{$accountId}/zones/{$zoneId}/v1/images/flows", $values);
    }
}
