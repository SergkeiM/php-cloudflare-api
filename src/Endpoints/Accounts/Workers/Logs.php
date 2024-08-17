<?php

namespace SergkeiM\CloudFlare\Endpoints\Accounts\Workers;

use SergkeiM\CloudFlare\Endpoints\AbstractEndpoint;
use SergkeiM\CloudFlare\Contracts\CloudFlareResponse;

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
     * @return CloudFlareResponse List Tails response
     */
    public function get(string $accountId, string $scriptName): CloudFlareResponse
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
     * @return CloudFlareResponse Start Tail response
     */
    public function start(string $accountId, string $scriptName): CloudFlareResponse
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
     * @return CloudFlareResponse Start Tail response
     */
    public function delete(string $accountId, string $scriptName, string $id): CloudFlareResponse
    {
        return $this->getHttpClient()->delete("/accounts/{$accountId}/workers/scripts/{$scriptName}/tails/{$id}");
    }
}
