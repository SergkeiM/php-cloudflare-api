<?php

namespace Cloudflare\Endpoints\Workers\Concerns;

use Cloudflare\Exceptions\MissingArgumentException;

/**
 * Building the multipart body Cloudflare expects when a Worker's code is sent:
 * a JSON `metadata` part describing the Worker, followed by one part per module
 * holding its source.
 *
 * Shared by uploading a script, replacing a script's content, and uploading a
 * version, which all take the same body.
 *
 * @link https://developers.cloudflare.com/workers/configuration/multipart-upload-metadata/
 */
trait UploadsModules
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
     * Build the multipart body for a set of modules.
     *
     * @param array $modules The modules making up the Worker. Each one is `['name' => 'worker.js', 'content' => '…']`, optionally with `'type'`.
     * @param array $metadata Multipart metadata. `main_module` is filled in from the first module when the metadata names no entry point.
     *
     * @throws MissingArgumentException
     *
     * @return array<int, array<string, mixed>>
     */
    protected function multipartModules(array $modules, array $metadata): array
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

        return $parts;
    }
}
