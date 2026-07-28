<?php

namespace Cloudflare\Endpoints\Zones;

use Cloudflare\Endpoints\AbstractEndpoint;
use Cloudflare\Contracts\ResponseInterface;

class RateLimits extends AbstractEndpoint
{
    /**
     * List, search, sort, and filter a zone's rate limits.
     *
     * @link https://developers.cloudflare.com/api/operations/rate-limits-for-a-zone-list-rate-limits
     *
     * @param string $zoneId Zone Identifier.
     * @param array $params Query Parameters.
     *
     * @return ResponseInterface List rate limits response
     */
    public function list(string $zoneId, array $params = []): ResponseInterface
    {
        return $this->getHttpClient()->get("/zones/{$zoneId}/rate_limits", $params);
    }

    /**
     * Get a single rate limit.
     *
     * @link https://developers.cloudflare.com/api/operations/rate-limits-for-a-zone-get-a-rate-limit
     *
     * @param string $zoneId Zone Identifier.
     * @param string $rateLimitId Rate Limit Identifier.
     *
     * @return ResponseInterface Get a rate limit response
     */
    public function details(string $zoneId, string $rateLimitId): ResponseInterface
    {
        return $this->getHttpClient()->get("/zones/{$zoneId}/rate_limits/{$rateLimitId}");
    }

    /**
     * Create a new rate limit for a zone.
     *
     * @link https://developers.cloudflare.com/api/operations/rate-limits-for-a-zone-create-a-rate-limit
     *
     * @param string $zoneId Zone Identifier.
     * @param array $values Values to set on the rate limit, e.g. `threshold`, `period`, `match`, `action`.
     *
     * @return ResponseInterface Create a rate limit response
     */
    public function create(string $zoneId, array $values): ResponseInterface
    {
        $this->requiredParams(['threshold', 'period', 'match', 'action'], $values);

        return $this->getHttpClient()->post("/zones/{$zoneId}/rate_limits", $values);
    }

    /**
     * Update an existing rate limit for a zone.
     *
     * @link https://developers.cloudflare.com/api/operations/rate-limits-for-a-zone-update-a-rate-limit
     *
     * @param string $zoneId Zone Identifier.
     * @param string $rateLimitId Rate Limit Identifier.
     * @param array $values Values to set on the rate limit, e.g. `threshold`, `period`, `match`, `action`.
     *
     * @return ResponseInterface Update a rate limit response
     */
    public function update(string $zoneId, string $rateLimitId, array $values): ResponseInterface
    {
        $this->requiredParams(['threshold', 'period', 'match', 'action'], $values);

        return $this->getHttpClient()->put("/zones/{$zoneId}/rate_limits/{$rateLimitId}", $values);
    }

    /**
     * Delete a rate limit for a zone.
     *
     * @link https://developers.cloudflare.com/api/operations/rate-limits-for-a-zone-delete-a-rate-limit
     *
     * @param string $zoneId Zone Identifier.
     * @param string $rateLimitId Rate Limit Identifier.
     *
     * @return ResponseInterface Delete a rate limit response
     */
    public function delete(string $zoneId, string $rateLimitId): ResponseInterface
    {
        return $this->getHttpClient()->delete("/zones/{$zoneId}/rate_limits/{$rateLimitId}");
    }
}
