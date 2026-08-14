<?php

namespace Cloudflare\Endpoints\Workers;

use Cloudflare\Endpoints\AbstractEndpoint;
use Cloudflare\Endpoints\Workers\Concerns\UploadsModules;
use Cloudflare\Contracts\ResponseInterface;
use GuzzleHttp\RequestOptions;

class Scripts extends AbstractEndpoint
{
    use UploadsModules;

    /**
     * Fetch a list of uploaded workers.
     *
     * @link https://developers.cloudflare.com/api/operations/worker-script-list-workers
     *
     * @param string $accountId Account identifier.
     *
     * @return ResponseInterface List Workers response
     */
    public function list(string $accountId): ResponseInterface
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
     * Upload a Worker, replacing the deployed script and its configuration.
     *
     * The request is a multipart upload: a JSON `metadata` part describing the
     * Worker, and one part per module holding its source. Bindings and settings
     * come from the metadata, so anything left out of it is dropped — send the
     * whole configuration, not just what changed. To replace only the code, use
     * `updateContent()`; to stage a Worker without deploying it, upload a
     * version instead.
     *
     * ```php
     * $client->workers()->scripts()->upload('ACCOUNT_ID', 'my-worker', [
     *     ['name' => 'worker.js', 'content' => file_get_contents('dist/worker.js')],
     * ], [
     *     'compatibility_date' => '2026-01-01',
     *     'bindings' => [
     *         ['type' => 'kv_namespace', 'name' => 'KV', 'namespace_id' => 'NAMESPACE_ID'],
     *     ],
     * ]);
     * ```
     *
     * @link https://developers.cloudflare.com/api/resources/workers/subresources/scripts/methods/update/
     * @link https://developers.cloudflare.com/workers/configuration/multipart-upload-metadata/
     *
     * @param string $accountId Account identifier.
     * @param string $scriptName Name of the script, used in URLs and route configuration.
     * @param array $modules The modules making up the Worker. Each one is `['name' => 'worker.js', 'content' => '…']`, optionally with `'type'` to override the default `application/javascript+module`.
     * @param array $metadata Multipart metadata: `compatibility_date`, `bindings`, `migrations`, `placement`, and so on. `main_module` defaults to the first module.
     * @param array $params Query Parameters, such as `['bindings_inherit' => 'strict']` to fail rather than silently drop bindings that cannot be inherited.
     *
     * @throws \Cloudflare\Exceptions\MissingArgumentException
     *
     * @return ResponseInterface Upload Worker Module response
     */
    public function upload(string $accountId, string $scriptName, array $modules, array $metadata = [], array $params = []): ResponseInterface
    {
        return $this->getHttpClient()->put(
            "/accounts/{$accountId}/workers/scripts/{$scriptName}",
            $this->multipartModules($modules, $metadata),
            $params === [] ? [] : ['query' => $params],
            RequestOptions::MULTIPART
        );
    }

    /**
     * Replace a Worker's code, leaving its configuration and metadata alone.
     *
     * The counterpart of `upload()` for a code-only deploy: bindings,
     * compatibility date and the rest of the Worker's settings are kept as they
     * are.
     *
     * ```php
     * $client->workers()->scripts()->updateContent('ACCOUNT_ID', 'my-worker', [
     *     ['name' => 'worker.js', 'content' => file_get_contents('dist/worker.js')],
     * ]);
     * ```
     *
     * @link https://developers.cloudflare.com/api/resources/workers/subresources/scripts/subresources/content/methods/update/
     *
     * @param string $accountId Account identifier.
     * @param string $scriptName Name of the script, used in URLs and route configuration.
     * @param array $modules The modules making up the Worker. Each one is `['name' => 'worker.js', 'content' => '…']`, optionally with `'type'` to override the default `application/javascript+module`.
     * @param array $metadata Multipart metadata naming the entry point. `main_module` defaults to the first module.
     *
     * @throws \Cloudflare\Exceptions\MissingArgumentException
     *
     * @return ResponseInterface Put script content response
     */
    public function updateContent(string $accountId, string $scriptName, array $modules, array $metadata = []): ResponseInterface
    {
        return $this->getHttpClient()->put(
            "/accounts/{$accountId}/workers/scripts/{$scriptName}/content",
            $this->multipartModules($modules, $metadata),
            format: RequestOptions::MULTIPART
        );
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
