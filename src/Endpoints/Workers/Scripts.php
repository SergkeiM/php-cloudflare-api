<?php

namespace Cloudflare\Endpoints\Workers;

use Cloudflare\Endpoints\AbstractEndpoint;
use Cloudflare\Contracts\ResponseInterface;
use Cloudflare\Exceptions\BadMethodCallException;

class Scripts extends AbstractEndpoint
{
    /**
     * Fetch a list of uploaded workers.
     *
     * @link https://developers.cloudflare.com/api/operations/worker-script-list-workers
     *
     * @param string $accountId Account identifier.
     *
     * @return ResponseInterface List Workers response
     */
    public function get(string $accountId): ResponseInterface
    {
        return $this->getHttpClient()->get("/accounts/{$accountId}/workers/scripts");
    }

    /**
     * Fetch raw script content for your worker. Note this is the original script content, not JSON encoded.
     *
     * @link https://developers.cloudflare.com/api/operations/worker-script-download-worker
     *
     * @param string $accountId Account identifier.
     * @param string $scriptName Name of the script, used in URLs and route configuration.
     *
     * @return ResponseInterface Download Worker response
     */
    public function download(string $accountId, string $scriptName): ResponseInterface
    {
        return $this->getHttpClient()->get("/accounts/{$accountId}/workers/scripts/{$scriptName}");
    }

    /**
     * Upload a worker module. You can find more about the multipart metadata on [Cloudflare Docs](https://developers.cloudflare.com/workers/configuration/multipart-upload-metadata/).
     *
     * @link https://developers.cloudflare.com/api/operations/worker-script-upload-worker-module
     *
     * @param string $accountId Account identifier.
     * @param string $scriptName Name of the script, used in URLs and route configuration.
     *
     * @return ResponseInterface Upload Worker Module response
     */
    public function upload(string $accountId, string $scriptName): ResponseInterface
    {
        //TODO
        // return $this->getHttpClient()->put("/accounts/{$accountId}/workers/scripts/{$scriptName}");

        throw new BadMethodCallException('Method update is not implemented yet');
    }

    /**
     * Put script content without touching config or metadata
     *
     * @link https://developers.cloudflare.com/api/operations/worker-script-put-content
     *
     * @param string $accountId Account identifier.
     * @param string $scriptName Name of the script, used in URLs and route configuration.
     *
     * @return ResponseInterface Upload Worker Module response
     */
    public function updateContent(string $accountId, string $scriptName): ResponseInterface
    {
        //TODO
        // return $this->getHttpClient()->put("/accounts/{$accountId}/workers/scripts/{$scriptName}/content");

        throw new BadMethodCallException('Method update is not implemented yet');
    }

    /**
     * Fetch script content only.
     *
     * @link https://developers.cloudflare.com/api/operations/worker-script-get-content
     *
     * @param string $accountId Account identifier.
     * @param string $scriptName Name of the script, used in URLs and route configuration.
     *
     * @return ResponseInterface Fetch script content
     */
    public function getContent(string $accountId, string $scriptName): ResponseInterface
    {
        return $this->getHttpClient()->get("/accounts/{$accountId}/workers/scripts/{$scriptName}/content/v2");
    }

    /**
     * Get script-level settings when using Worker Versions. Includes Logpush and Tail Consumers.
     *
     * @link https://developers.cloudflare.com/api/operations/worker-script-settings-get-settings
     *
     * @param string $accountId Account identifier.
     * @param string $scriptName Name of the script, used in URLs and route configuration.
     *
     * @return ResponseInterface Fetch script settings
     */
    public function getScriptSettings(string $accountId, string $scriptName): ResponseInterface
    {
        return $this->getHttpClient()->get("/accounts/{$accountId}/workers/scripts/{$scriptName}/script-settings");
    }

    /**
     * Patch script-level settings when using Worker Versions. Includes Logpush and Tail Consumers.
     *
     * @link https://developers.cloudflare.com/api/operations/worker-script-settings-patch-settings
     *
     * @param string $accountId Account identifier.
     * @param string $scriptName Name of the script, used in URLs and route configuration.
     * @param array $values Script settings values.
     *
     * @return ResponseInterface Patch script settings
     */
    public function updateScriptSettings(string $accountId, string $scriptName, array $values): ResponseInterface
    {
        return $this->getHttpClient()->patch("/accounts/{$accountId}/workers/scripts/{$scriptName}/script-settings", $values);
    }

    /**
     * Get metadata and config, such as bindings or usage model
     *
     * @link https://developers.cloudflare.com/api/operations/worker-script-get-settings
     *
     * @param string $accountId Account identifier.
     * @param string $scriptName Name of the script, used in URLs and route configuration.
     *
     * @return ResponseInterface Fetch settings
     */
    public function getSettings(string $accountId, string $scriptName): ResponseInterface
    {
        return $this->getHttpClient()->get("/accounts/{$accountId}/workers/scripts/{$scriptName}/settings");
    }

    /**
     * Patch metadata or config, such as bindings or usage model
     *
     * @link https://developers.cloudflare.com/api/operations/worker-script-patch-settings
     *
     * @param string $accountId Account identifier.
     * @param string $scriptName Name of the script, used in URLs and route configuration.
     * @param array $values Settings values.
     *
     * @return ResponseInterface Patch settings
     */
    public function updateSettings(string $accountId, string $scriptName, array $values): ResponseInterface
    {
        return $this->getHttpClient()->patch("/accounts/{$accountId}/workers/scripts/{$scriptName}/settings", $values);
    }

    /**
     * Fetches the Usage Model for a given Worker.
     *
     * @link https://developers.cloudflare.com/api/operations/worker-script-fetch-usage-model
     *
     * @param string $accountId Account identifier.
     * @param string $scriptName Name of the script, used in URLs and route configuration.
     *
     * @return ResponseInterface Fetch Usage Model response
     */
    public function getUsageModel(string $accountId, string $scriptName): ResponseInterface
    {
        return $this->getHttpClient()->get("/accounts/{$accountId}/workers/scripts/{$scriptName}/usage-model");
    }

    /**
     * Updates the Usage Model for a given Worker. Requires a Workers Paid subscription.
     *
     * @link https://developers.cloudflare.com/api/operations/worker-script-update-usage-model
     *
     * @param string $accountId Account identifier.
     * @param string $scriptName Name of the script, used in URLs and route configuration.
     * @param string $usageModel Usage model.
     *
     * @return ResponseInterface Patch settings
     */
    public function updateUsageModel(string $accountId, string $scriptName, string $usageModel): ResponseInterface
    {
        return $this->getHttpClient()->put("/accounts/{$accountId}/workers/scripts/{$scriptName}/usage-model", [
            'usage_model' => $usageModel
        ]);
    }

    /**
     * Delete your worker. This call has no response body on a successful delete.
     *
     * @link https://developers.cloudflare.com/api/operations/worker-script-delete-worker
     *
     * @param string $accountId Account identifier.
     * @param string $scriptName Name of the script, used in URLs and route configuration.
     * @param boolean $force If set to true, delete will not be stopped by associated service binding, durable object, or other binding. Any of these associated bindings/durable objects will be deleted along with the script.
     *
     * @return ResponseInterface Delete Worker response
     */
    public function delete(string $accountId, string $scriptName, bool $force = false): ResponseInterface
    {
        return $this->getHttpClient()->delete("/accounts/{$accountId}/workers/scripts/{$scriptName}", [
            'force' => $force
        ], [], 'query');
    }
}
