<?php

namespace CloudFlare\Endpoints\Workers;

use CloudFlare\Endpoints\AbstractEndpoint;
use CloudFlare\Contracts\CloudFlareResponse;

class DurableObjects extends AbstractEndpoint
{
    /**
     * Returns the Durable Object namespaces owned by an account.
     *
     * @link https://developers.cloudflare.com/api/operations/durable-objects-namespace-list-namespaces
     *
     * @param string $accountId Account identifier.
     * @param array $params Array containing the necessary params.
     *
     * @return CloudFlareResponse List Namespaces response
     */
    public function list(string $accountId, array $params = []): CloudFlareResponse
    {
        return $this->getHttpClient()->get("/accounts/{$accountId}/workers/durable_objects/namespaces", $params);
    }

    /**
     * Returns the Durable Object namespaces owned by an account.
     *
     * @link https://developers.cloudflare.com/api/operations/durable-objects-namespace-list-namespaces
     *
     * @param string $accountId Account identifier.
     * @param string $id ID of the namespace.
     * @param array $params Array containing the necessary params.
     *
     * @return CloudFlareResponse List Objects response
     */
    public function listObjects(string $accountId, string $id, array $params = []): CloudFlareResponse
    {
        return $this->getHttpClient()->get("/accounts/{$accountId}/workers/durable_objects/namespaces/{$id}/objectss", $params);
    }
}
