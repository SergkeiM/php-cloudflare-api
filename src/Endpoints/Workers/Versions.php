<?php

namespace Cloudflare\Endpoints\Workers;

use Cloudflare\Endpoints\AbstractEndpoint;
use Cloudflare\Contracts\ResponseInterface;
use Cloudflare\Exceptions\MissingArgumentException;
use GuzzleHttp\RequestOptions;

class Versions extends AbstractEndpoint
{
    /**
     * Content type for a module, unless the module names its own.
     *
     * ES modules are what `wrangler` emits and what Cloudflare's own examples
     * use. A service worker script wants `application/javascript`, WebAssembly
     * `application/wasm`, and a source map `application/source-map`.
     */
    public const DEFAULT_MODULE_TYPE = 'application/javascript+module';

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
     * Upload a Worker Version without deploying it to Cloudflare's network.
     *
     * The request is a multipart upload: a JSON `metadata` part describing the
     * Worker, and one part per module holding its source. Deploy the version
     * afterwards with `$client->workers()->deployments()->create()`.
     *
     * ```php
     * $client->workers()->versions()->upload('ACCOUNT_ID', 'my-worker', [
     *     ['name' => 'worker.js', 'content' => file_get_contents('dist/worker.js')],
     * ], [
     *     'compatibility_date' => '2026-01-01',
     *     'bindings' => [
     *         ['type' => 'plain_text', 'name' => 'MESSAGE', 'text' => 'Hello, world!'],
     *     ],
     * ]);
     * ```
     *
     * @link https://developers.cloudflare.com/api/resources/workers/subresources/scripts/subresources/versions/methods/create/
     * @link https://developers.cloudflare.com/workers/configuration/multipart-upload-metadata/
     *
     * @param string $accountId Account identifier.
     * @param string $scriptName Name of the script, used in URLs and route configuration.
     * @param array $modules The modules making up the Worker. Each one is `['name' => 'worker.js', 'content' => '…']`, optionally with `'type'` to override the default `application/javascript+module`.
     * @param array $metadata Multipart metadata: `compatibility_date`, `bindings`, `migrations`, `placement`, and so on. `main_module` defaults to the first module.
     *
     * @throws \Cloudflare\Exceptions\MissingArgumentException
     *
     * @return ResponseInterface Upload Version response
     */
    public function upload(string $accountId, string $scriptName, array $modules, array $metadata = []): ResponseInterface
    {
        if ($modules === []) {
            throw new MissingArgumentException('modules');
        }

        foreach ($modules as $module) {
            if (!isset($module['name'], $module['content'])) {
                throw new MissingArgumentException(['name', 'content']);
            }
        }

        // Cloudflare needs to know which module to run. `body_part` is the
        // service worker equivalent, so only fill in the module entry point
        // when neither is given.
        if (!isset($metadata['main_module']) && !isset($metadata['body_part'])) {
            $metadata['main_module'] = $modules[array_key_first($modules)]['name'];
        }

        $parts = [
            [
                'name' => 'metadata',
                'contents' => json_encode($metadata),
                'headers' => ['Content-Type' => 'application/json'],
            ],
        ];

        foreach ($modules as $module) {
            $parts[] = [
                'name' => $module['name'],
                'filename' => $module['name'],
                'contents' => $module['content'],
                'headers' => ['Content-Type' => $module['type'] ?? self::DEFAULT_MODULE_TYPE],
            ];
        }

        return $this->getHttpClient()->post(
            "/accounts/{$accountId}/workers/scripts/{$scriptName}/versions",
            $parts,
            format: RequestOptions::MULTIPART
        );
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
    public function get(string $accountId, string $scriptName, string $versionId): ResponseInterface
    {
        return $this->getHttpClient()->get("/accounts/{$accountId}/workers/scripts/{$scriptName}/versions/{$versionId}");
    }
}
