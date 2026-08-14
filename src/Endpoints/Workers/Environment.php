<?php

namespace Cloudflare\Endpoints\Workers;

use Cloudflare\Endpoints\AbstractEndpoint;
use Cloudflare\Endpoints\Workers\Concerns\UploadsModules;
use Cloudflare\Contracts\ResponseInterface;
use GuzzleHttp\RequestOptions;

class Environment extends AbstractEndpoint
{
    use UploadsModules;

    /**
     * Get script content from a worker with an environment
     *
     * @link https://developers.cloudflare.com/api/operations/worker-environment-get-script-content
     *
     * @param string $accountId Account identifier.
     * @param string $serviceName Name of Worker to bind to
     * @param string $environmentName Environment of the Worker.
     *
     * @return ResponseInterface Get script content response
     */
    public function get(string $accountId, string $serviceName, string $environmentName): ResponseInterface
    {
        return $this->getHttpClient()->get("/accounts/{$accountId}/workers/services/{$serviceName}/environments/{$environmentName}/content");
    }

    /**
     * Replace the code of a Worker in a given environment.
     *
     * The request is a multipart upload: a JSON `metadata` part naming the
     * entry point, and one part per module holding its source. Settings and
     * bindings for the environment are left alone.
     *
     * ```php
     * $client->workers()->environment()->update('ACCOUNT_ID', 'my-worker', 'production', [
     *     ['name' => 'worker.js', 'content' => file_get_contents('dist/worker.js')],
     * ]);
     * ```
     *
     * @link https://developers.cloudflare.com/api/operations/worker-environment-put-script-content
     * @link https://developers.cloudflare.com/workers/configuration/multipart-upload-metadata/
     *
     * @param string $accountId Account identifier.
     * @param string $serviceName Name of Worker to bind to
     * @param string $environmentName Environment of the Worker.
     * @param array $modules The modules making up the Worker. Each one is `['name' => 'worker.js', 'content' => '…']`, optionally with `'type'` to override the default `application/javascript+module`.
     * @param array $metadata Multipart metadata naming the entry point. `main_module` defaults to the first module.
     *
     * @throws \Cloudflare\Exceptions\MissingArgumentException
     *
     * @return ResponseInterface Put script content response
     */
    public function update(string $accountId, string $serviceName, string $environmentName, array $modules, array $metadata = []): ResponseInterface
    {
        return $this->getHttpClient()->put(
            "/accounts/{$accountId}/workers/services/{$serviceName}/environments/{$environmentName}/content",
            $this->multipartModules($modules, $metadata),
            format: RequestOptions::MULTIPART
        );
    }

    /**
     * Get script settings from a worker with an environment
     *
     * @link https://developers.cloudflare.com/api/operations/worker-script-environment-get-settings
     *
     * @param string $accountId Account identifier.
     * @param string $serviceName Name of Worker to bind to
     * @param string $environmentName Environment of the Worker.
     *
     * @return ResponseInterface Get script content response
     */
    public function getSettings(string $accountId, string $serviceName, string $environmentName): ResponseInterface
    {
        return $this->getHttpClient()->get("/accounts/{$accountId}/workers/services/{$serviceName}/environments/{$environmentName}/settings");
    }

    /**
     * Patch script metadata, such as bindings
     *
     * @link https://developers.cloudflare.com/api/operations/worker-script-environment-patch-settings
     *
     * @param string $accountId Account identifier.
     * @param string $serviceName Name of Worker to bind to
     * @param string $environmentName Environment of the Worker.
     * @param array $values Settings values.
     *
     * @return ResponseInterface Patch script settings
     */
    public function updateSettings(string $accountId, string $serviceName, string $environmentName, array $values): ResponseInterface
    {
        return $this->getHttpClient()->patch("/accounts/{$accountId}/workers/services/{$serviceName}/environments/{$environmentName}/settings", $values);
    }
}
