<?php

namespace Cloudflare\Endpoints\Zones;

use Cloudflare\Endpoints\AbstractEndpoint;
use Cloudflare\Contracts\ResponseInterface;

class Filters extends AbstractEndpoint
{
    /**
     * List, search, sort, and filter a zone's filters.
     *
     * @link https://developers.cloudflare.com/api/operations/filters-list-filters
     *
     * @param string $zoneId Zone Identifier.
     * @param array $params Query Parameters.
     *
     * @return ResponseInterface List filters response
     */
    public function list(string $zoneId, array $params = []): ResponseInterface
    {
        return $this->getHttpClient()->get("/zones/{$zoneId}/filters", $params);
    }

    /**
     * Get a single filter.
     *
     * @link https://developers.cloudflare.com/api/operations/filters-filter-details
     *
     * @param string $zoneId Zone Identifier.
     * @param string $filterId Filter Identifier.
     *
     * @return ResponseInterface Get a filter response
     */
    public function details(string $zoneId, string $filterId): ResponseInterface
    {
        return $this->getHttpClient()->get("/zones/{$zoneId}/filters/{$filterId}");
    }

    /**
     * Create one or more filters.
     *
     * @link https://developers.cloudflare.com/api/operations/filters-create-filters
     *
     * @param string $zoneId Zone Identifier.
     * @param array $filters Array of filter definitions, e.g. `[['expression' => 'ip.src eq 127.0.0.1']]`.
     *
     * @return ResponseInterface Create filters response
     */
    public function create(string $zoneId, array $filters): ResponseInterface
    {
        return $this->getHttpClient()->post("/zones/{$zoneId}/filters", $filters);
    }

    /**
     * Update an existing filter.
     *
     * @link https://developers.cloudflare.com/api/operations/filters-update-a-filter
     *
     * @param string $zoneId Zone Identifier.
     * @param string $filterId Filter Identifier.
     * @param array $values Values to set on the filter.
     *
     * @return ResponseInterface Update a filter response
     */
    public function update(string $zoneId, string $filterId, array $values): ResponseInterface
    {
        $this->requiredParams(['expression'], $values);

        return $this->getHttpClient()->put("/zones/{$zoneId}/filters/{$filterId}", $values);
    }

    /**
     * Delete a filter.
     *
     * @link https://developers.cloudflare.com/api/operations/filters-delete-a-filter
     *
     * @param string $zoneId Zone Identifier.
     * @param string $filterId Filter Identifier.
     *
     * @return ResponseInterface Delete a filter response
     */
    public function delete(string $zoneId, string $filterId): ResponseInterface
    {
        return $this->getHttpClient()->delete("/zones/{$zoneId}/filters/{$filterId}");
    }
}
