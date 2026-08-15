<?php

namespace Cloudflare\Endpoints;

use Cloudflare\Contracts\ResponseInterface;

/**
 * Zaraz: third-party tool loading, configured per zone and served from the edge.
 *
 * A zone carries two configurations at once — the preview one you edit, and the
 * published one your visitors get. `updateConfig()` writes the preview,
 * `publish()` promotes it. Every published configuration is kept, so
 * `history()` lists them and `restore()` rolls back to one.
 *
 * @link https://developers.cloudflare.com/zaraz/
 */
class Zaraz extends AbstractEndpoint
{
    /**
     * Get the latest Zaraz configuration for a zone.
     *
     * Returns whichever of the preview or published configuration was updated
     * last. Values of secret variables are omitted — use `export()` to get
     * them.
     *
     * @link https://developers.cloudflare.com/api/resources/zaraz/subresources/config/methods/get/
     *
     * @param string $zoneId Zone Identifier.
     *
     * @return \Cloudflare\Contracts\ResponseInterface Get Zaraz configuration response
     */
    public function getConfig(string $zoneId): ResponseInterface
    {
        return $this->getHttpClient()->get("/zones/{$zoneId}/settings/zaraz/config");
    }

    /**
     * Update the Zaraz configuration for a zone.
     *
     * This writes the preview configuration; call `publish()` to make it live.
     * Cloudflare replaces the whole configuration, so send a complete one —
     * read the current config, change what you need, and send it back.
     *
     * ```php
     * $config = $client->zaraz()->getConfig('ZONE_ID')->json('result');
     * $config['debugKey'] = 'new-debug-key';
     *
     * $client->zaraz()->updateConfig('ZONE_ID', $config);
     * ```
     *
     * @link https://developers.cloudflare.com/api/resources/zaraz/subresources/config/methods/update/
     *
     * @param string $zoneId Zone Identifier.
     * @param array $values The complete configuration: `dataLayer`, `debugKey`, `settings`, `triggers`, `variables`, `tools` and `zarazVersion` are all required, with `analytics`, `consent` and `historyChange` optional.
     *
     * @throws \Cloudflare\Exceptions\MissingArgumentException
     *
     * @return \Cloudflare\Contracts\ResponseInterface Update Zaraz configuration response
     */
    public function updateConfig(string $zoneId, array $values): ResponseInterface
    {
        $this->requiredParams(['dataLayer', 'debugKey', 'settings', 'triggers', 'variables', 'tools', 'zarazVersion'], $values);

        return $this->getHttpClient()->put("/zones/{$zoneId}/settings/zaraz/config", $values);
    }

    /**
     * Get the default Zaraz configuration for a zone.
     *
     * The configuration a zone starts from, useful as a baseline to reset to.
     *
     * @link https://developers.cloudflare.com/api/resources/zaraz/subresources/default/methods/get/
     *
     * @param string $zoneId Zone Identifier.
     *
     * @return \Cloudflare\Contracts\ResponseInterface Get default Zaraz configuration response
     */
    public function getDefault(string $zoneId): ResponseInterface
    {
        return $this->getHttpClient()->get("/zones/{$zoneId}/settings/zaraz/default");
    }

    /**
     * Export the published Zaraz configuration for a zone.
     *
     * Unlike `getConfig()`, this returns the published configuration in full,
     * secret variable values included.
     *
     * @link https://developers.cloudflare.com/api/resources/zaraz/subresources/export/methods/get/
     *
     * @param string $zoneId Zone Identifier.
     *
     * @return \Cloudflare\Contracts\ResponseInterface Export Zaraz configuration response
     */
    public function export(string $zoneId): ResponseInterface
    {
        return $this->getHttpClient()->get("/zones/{$zoneId}/settings/zaraz/export");
    }

    /**
     * List published Zaraz configuration records for a zone.
     *
     * @link https://developers.cloudflare.com/api/resources/zaraz/subresources/history/methods/list/
     *
     * @param string $zoneId Zone Identifier.
     * @param array $params Query Parameters: `offset` (default `0`), `limit` (default `10`), `sortField` (one of `id`, `user_id`, `description`, `created_at`, `updated_at`) and `sortOrder` (`DESC` or `ASC`).
     *
     * @return \Cloudflare\Contracts\ResponseInterface List Zaraz historical configuration records response
     */
    public function history(string $zoneId, array $params = []): ResponseInterface
    {
        return $this->getHttpClient()->get("/zones/{$zoneId}/settings/zaraz/history", $params);
    }

    /**
     * Restore a published Zaraz configuration by ID.
     *
     * @link https://developers.cloudflare.com/api/resources/zaraz/subresources/history/methods/update/
     *
     * @param string $zoneId Zone Identifier.
     * @param int $configId ID of the historical configuration to restore, as listed by `history()`.
     *
     * @return \Cloudflare\Contracts\ResponseInterface Restore Zaraz historical configuration response
     */
    public function restore(string $zoneId, int $configId): ResponseInterface
    {
        // Cloudflare wants the ID as a bare JSON number, not wrapped in an object.
        return $this->getHttpClient()->put("/zones/{$zoneId}/settings/zaraz/history", $configId);
    }

    /**
     * Get published Zaraz configurations by ID.
     *
     * @link https://developers.cloudflare.com/api/resources/zaraz/subresources/history/subresources/configs/methods/get/
     *
     * @param string $zoneId Zone Identifier.
     * @param array $ids IDs of the historical configurations to fetch.
     *
     * @throws \Cloudflare\Exceptions\MissingArgumentException
     *
     * @return \Cloudflare\Contracts\ResponseInterface Get Zaraz historical configurations response
     */
    public function configs(string $zoneId, array $ids): ResponseInterface
    {
        $this->requiredParams(['ids'], ['ids' => $ids]);

        // Cloudflare reads `ids` as one comma-separated value, not as repeated
        // query parameters.
        return $this->getHttpClient()->get("/zones/{$zoneId}/settings/zaraz/history/configs", [
            'ids' => implode(',', $ids),
        ]);
    }

    /**
     * Get the Zaraz workflow for a zone.
     *
     * The workflow decides which configuration visitors are served: `realtime`
     * serves the published one, `preview` serves the one you are editing.
     *
     * @link https://developers.cloudflare.com/api/resources/zaraz/subresources/workflow/methods/get/
     *
     * @param string $zoneId Zone Identifier.
     *
     * @return \Cloudflare\Contracts\ResponseInterface Get Zaraz workflow response
     */
    public function getWorkflow(string $zoneId): ResponseInterface
    {
        return $this->getHttpClient()->get("/zones/{$zoneId}/settings/zaraz/workflow");
    }

    /**
     * Update the Zaraz workflow for a zone.
     *
     * @link https://developers.cloudflare.com/api/resources/zaraz/methods/update/
     *
     * @param string $zoneId Zone Identifier.
     * @param string $workflow Either `realtime` or `preview`.
     *
     * @return \Cloudflare\Contracts\ResponseInterface Update Zaraz workflow response
     */
    public function updateWorkflow(string $zoneId, string $workflow): ResponseInterface
    {
        // Cloudflare wants the workflow as a bare JSON string, not wrapped in an object.
        return $this->getHttpClient()->put("/zones/{$zoneId}/settings/zaraz/workflow", $workflow);
    }

    /**
     * Publish the current Zaraz preview configuration for a zone.
     *
     * @link https://developers.cloudflare.com/api/resources/zaraz/subresources/publish/methods/create/
     *
     * @param string $zoneId Zone Identifier.
     * @param string $description Description recorded against the published configuration, and shown in `history()`.
     *
     * @return \Cloudflare\Contracts\ResponseInterface Publish Zaraz preview configuration response
     */
    public function publish(string $zoneId, string $description = ''): ResponseInterface
    {
        // Cloudflare wants the description as a bare JSON string, not wrapped in an object.
        return $this->getHttpClient()->post("/zones/{$zoneId}/settings/zaraz/publish", $description);
    }
}
