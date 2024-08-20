<?php

namespace Cloudflare\Endpoints\Workers;

use Cloudflare\Endpoints\AbstractEndpoint;
use Cloudflare\Contracts\ResponseInterface;

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
     * @return ResponseInterface List Namespaces response
     */
    public function list(string $accountId, array $params = []): ResponseInterface
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
     * @return ResponseInterface List Objects response
     */
    public function listObjects(string $accountId, string $id, array $params = []): ResponseInterface
    {
        return $this->getHttpClient()->get("/accounts/{$accountId}/workers/durable_objects/namespaces/{$id}/objectss", $params);
    }
}
