<?php

namespace Cloudflare\Endpoints\Workers;

use Cloudflare\Endpoints\AbstractEndpoint;
use Cloudflare\Contracts\ResponseInterface;

class Routes extends AbstractEndpoint
{
    /**
     * Returns routes for a zone.
     *
     * @link https://developers.cloudflare.com/api/operations/worker-routes-list-routes
     *
     * @param string $zoneId Zone identifier.
     *
     * @return ResponseInterface List available Workers Routes response.
     */
    public function get(string $zoneId, array $params = []): ResponseInterface
    {
        return $this->getHttpClient()->get("/zones/{$zoneId}/workers/routes", $params);
    }

    /**
     * Creates a route that maps a URL pattern to a Worker.
     *
     * @link https://developers.cloudflare.com/api/operations/worker-routes-create-route
     *
     * @param string $zoneId Zone identifier.
     * @param array $values Values.
     *
     * @return ResponseInterface Create Route response
     */
    public function create(string $zoneId, array $values): ResponseInterface
    {
        $this->requiredParams(['pattern'], $values);

        return $this->$this->getHttpClient()->post("/zones/{$zoneId}/workers/routes", $values);
    }

    /**
     * Returns information about a route, including URL pattern and Worker.
     *
     * @link https://developers.cloudflare.com/api/operations/worker-routes-get-route
     *
     * @param string $zoneId Zone identifier.
     * @param string $routeId Route Identifier.
     *
     * @return ResponseInterface Get Route response
     */
    public function details(string $zoneId, string $routeId): ResponseInterface
    {
        return $this->getHttpClient()->get("/zones/{$zoneId}/workers/routes/{$routeId}");
    }

    /**
     * Updates the URL pattern or Worker associated with a route.
     *
     * @link https://developers.cloudflare.com/api/operations/worker-routes-update-route
     *
     * @param string $zoneId Zone identifier.
     * @param string $routeId Route Identifier.
     * @param array $values Values.
     *
     * @return ResponseInterface Update Route response
     */
    public function update(string $zoneId, string $routeId, array $values): ResponseInterface
    {
        return $this->getHttpClient()->put("/zones/{$zoneId}/workers/routes/{$routeId}", $values);
    }

    /**
     * Deletes a route.
     *
     * @link https://developers.cloudflare.com/api/operations/worker-routes-delete-route
     *
     * @param string $zoneId Zone identifier.
     * @param string $routeId Route Identifier.
     *
     * @return ResponseInterface Delete Route response.
     */
    public function delete(string $zoneId, string $routeId): ResponseInterface
    {
        return $this->getHttpClient()->delete("/zones/{$zoneId}/workers/routes/{$routeId}");
    }
}
