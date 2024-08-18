<?php

namespace SergkeiM\CloudFlare\Endpoints\Workers;

use SergkeiM\CloudFlare\Endpoints\AbstractEndpoint;
use SergkeiM\CloudFlare\Contracts\CloudFlareResponse;
use SergkeiM\CloudFlare\Exceptions\BadMethodCallException;

class Scripts extends AbstractEndpoint
{
    /**
     * Fetch a list of uploaded workers.
     *
     * @link https://developers.cloudflare.com/api/operations/worker-script-list-workers
     *
     * @param string $accountId Account identifier.
     *
     * @return CloudFlareResponse List Workers response
     */
    public function get(string $accountId): CloudFlareResponse
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
     * @return CloudFlareResponse Download Worker response
     */
    public function download(string $accountId, string $scriptName): CloudFlareResponse
    {
        return $this->getHttpClient()->get("/accounts/{$accountId}/workers/scripts/{$scriptName}");
    }

    /**
     * Upload a worker module. You can find more about the multipart metadata on [CloudFlare Docs](https://developers.cloudflare.com/workers/configuration/multipart-upload-metadata/).
     *
     * @link https://developers.cloudflare.com/api/operations/worker-script-upload-worker-module
     *
     * @param string $accountId Account identifier.
     * @param string $scriptName Name of the script, used in URLs and route configuration.
     *
     * @return CloudFlareResponse Upload Worker Module response
     */
    public function upload(string $accountId, string $scriptName): CloudFlareResponse
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
     * @return CloudFlareResponse Upload Worker Module response
     */
    public function updateContent(string $accountId, string $scriptName): CloudFlareResponse
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
     * @return CloudFlareResponse Fetch script content
     */
    public function getContent(string $accountId, string $scriptName): CloudFlareResponse
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
     * @return CloudFlareResponse Fetch script settings
     */
    public function getScriptSettings(string $accountId, string $scriptName): CloudFlareResponse
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
     * @return CloudFlareResponse Patch script settings
     */
    public function updateScriptSettings(string $accountId, string $scriptName, array $values): CloudFlareResponse
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
     * @return CloudFlareResponse Fetch settings
     */
    public function getSettings(string $accountId, string $scriptName): CloudFlareResponse
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
     * @return CloudFlareResponse Patch settings
     */
    public function updateSettings(string $accountId, string $scriptName, array $values): CloudFlareResponse
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
     * @return CloudFlareResponse Fetch Usage Model response
     */
    public function getUsageModel(string $accountId, string $scriptName): CloudFlareResponse
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
     * @return CloudFlareResponse Patch settings
     */
    public function updateUsageModel(string $accountId, string $scriptName, string $usageModel): CloudFlareResponse
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
     * @return CloudFlareResponse Delete Worker response
     */
    public function delete(string $accountId, string $scriptName, bool $force = false): CloudFlareResponse
    {
        return $this->getHttpClient()->delete("/accounts/{$accountId}/workers/scripts/{$scriptName}", [
            'force' => $force
        ]);
    }
}
