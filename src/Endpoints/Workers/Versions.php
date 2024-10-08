<?php

namespace Cloudflare\Endpoints\Workers;

use Cloudflare\Endpoints\AbstractEndpoint;
use Cloudflare\Contracts\ResponseInterface;
use Cloudflare\Exceptions\BadMethodCallException;

class Versions extends AbstractEndpoint
{
    /**
     * List of Worker Versions. The first version in the list is the latest version.
     *
     * @link https://developers.cloudflare.com/api/operations/worker-versions-list-versions
     *
     * @param string $accountId Account identifier.
     * @param string $scriptName Name of the script, used in URLs and route configuration.
     * @param array $params Array containing the necessary params.
     *
     * @return ResponseInterface List Versions response
     */
    public function list(string $accountId, string $scriptName, array $params = []): ResponseInterface
    {
        return $this->getHttpClient()->get("/accounts/{$accountId}/workers/scripts/{$scriptName}/versions", $params);
    }

    /**
     * Upload a Worker Version without deploying to Cloudflare's network. You can find more about the multipart metadata on [Cloudflare docs](https://developers.cloudflare.com/workers/configuration/multipart-upload-metadata/).
     *
     * @link https://developers.cloudflare.com/api/operations/worker-versions-upload-version
     *
     * @param string $accountId Account identifier.
     * @param string $scriptName Name of the script, used in URLs and route configuration.
     *
     * @return ResponseInterface Start Tail response
     */
    public function upload(string $accountId, string $scriptName): ResponseInterface
    {
        //TODO
        //return $this->getHttpClient()->post("/accounts/{$accountId}/workers/scripts/{$scriptName}/tails");
        throw new BadMethodCallException('Method update is not implemented yet');
    }

    /**
     * Get Version Details.
     *
     * @link https://developers.cloudflare.com/api/operations/worker-versions-get-version-detail
     *
     * @param string $accountId Account identifier.
     * @param string $scriptName Name of the script, used in URLs and route configuration.
     * @param string $versionId Version identifier.
     *
     * @return ResponseInterface Get Version Detail response
     */
    public function details(string $accountId, string $scriptName, string $versionId): ResponseInterface
    {
        return $this->getHttpClient()->get("/accounts/{$accountId}/workers/scripts/{$scriptName}/versions/{$versionId}");
    }
}
