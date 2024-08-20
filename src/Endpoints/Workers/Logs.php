<?php

namespace Cloudflare\Endpoints\Workers;

use Cloudflare\Endpoints\AbstractEndpoint;
use Cloudflare\Contracts\ResponseInterface;

class Logs extends AbstractEndpoint
{
    /**
     * Get list of tails currently deployed on a Worker.
     *
     * @link https://developers.cloudflare.com/api/operations/worker-tail-logs-list-tails
     *
     * @param string $accountId Account identifier.
     * @param string $scriptName Name of the script, used in URLs and route configuration.
     *
     * @return ResponseInterface List Tails response
     */
    public function get(string $accountId, string $scriptName): ResponseInterface
    {
        return $this->getHttpClient()->get("/accounts/{$accountId}/workers/scripts/{$scriptName}/tails");
    }

    /**
     * Starts a tail that receives logs and exception from a Worker.
     *
     * @link https://developers.cloudflare.com/api/operations/worker-tail-logs-start-tail
     *
     * @param string $accountId Account identifier.
     * @param string $scriptName Name of the script, used in URLs and route configuration.
     *
     * @return ResponseInterface Start Tail response
     */
    public function start(string $accountId, string $scriptName): ResponseInterface
    {
        return $this->getHttpClient()->post("/accounts/{$accountId}/workers/scripts/{$scriptName}/tails");
    }

    /**
     * Deletes a tail from a Worker.
     *
     * @link https://developers.cloudflare.com/api/operations/worker-tail-logs-delete-tail
     *
     * @param string $accountId Account identifier.
     * @param string $scriptName Name of the script, used in URLs and route configuration.
     * @param string $id Identifier for the tail.
     *
     * @return ResponseInterface Start Tail response
     */
    public function delete(string $accountId, string $scriptName, string $id): ResponseInterface
    {
        return $this->getHttpClient()->delete("/accounts/{$accountId}/workers/scripts/{$scriptName}/tails/{$id}");
    }
}
