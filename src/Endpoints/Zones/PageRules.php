<?php

namespace CloudFlare\Endpoints\Zones;

use CloudFlare\Endpoints\AbstractEndpoint;
use CloudFlare\Contracts\CloudFlareResponse;

class PageRules extends AbstractEndpoint
{
    /**
     * Returns a list of settings (and their details) that Page Rules can apply to matching requests.
     *
     * @link https://developers.cloudflare.com/api/operations/available-page-rules-settings-list-available-page-rules-settings
     *
     * @param string $zoneId Zone Identifier.
     *
     * @return CloudFlareResponse List available Page Rules settings response
     */
    public function settings(string $zoneId): CloudFlareResponse
    {
        return $this->getHttpClient()->get("/zones/{$zoneId}/pagerules/settings");
    }

    /**
     * List Page Rules in a zone.
     *
     * @link https://developers.cloudflare.com/api/operations/page-rules-list-page-rules
     *
     * @param string $zoneId Zone Identifier.
     * @param array $params Query Parameters
     *
     * @return CloudFlareResponse List Page Rules response
     */
    public function list(string $zoneId, array $params = []): CloudFlareResponse
    {
        return $this->getHttpClient()->get("/zones/{$zoneId}/pagerules", $params);
    }

    /**
     * Create a Page Rule
     *
     * @link https://developers.cloudflare.com/api/operations/page-rules-create-a-page-rule
     *
     * @param string $zoneId Zone Identifier.
     * @param array $values Values to set on Page Rule.
     *
     * @return CloudFlareResponse Create a Page Rule response
     */
    public function create(string $zoneId, array $values): CloudFlareResponse
    {
        $this->requiredParams(['actions', 'targets'], $values);

        return $this->$this->getHttpClient()->post("/zones/{$zoneId}/pagerules", $values);
    }

    /**
     * Fetches the details of a Page Rule.
     *
     * @link https://developers.cloudflare.com/api/operations/page-rules-get-a-page-rule
     *
     * @param string $zoneId Zone Identifier.
     * @param string $pageRuleId Page Rule ID to fetch details.
     *
     * @return CloudFlareResponse Get a Page Rule response
     */
    public function details(string $zoneId, string $pageRuleId): CloudFlareResponse
    {
        return $this->getHttpClient()->get("/zones/{$zoneId}/pagerules/{$pageRuleId}");
    }

    /**
     * Updates one or more fields of an existing Page Rule.
     *
     * @link https://developers.cloudflare.com/api/operations/page-rules-edit-a-page-rule
     *
     * @param string $zoneId Zone Identifier.
     * @param string $pageRuleId Page Rule ID to update.
     *
     * @return CloudFlareResponse Edit a Page Rule response
     */
    public function update(string $zoneId, string $pageRuleId, array $values): CloudFlareResponse
    {
        return $this->getHttpClient()->patch("/zones/{$zoneId}/pagerules/{$pageRuleId}", $values);
    }

    /**
     * Replaces the configuration of an existing Page Rule. The configuration of the updated Page Rule will exactly match the data passed in the API request.
     *
     * @link https://developers.cloudflare.com/api/operations/page-rules-update-a-page-rule
     *
     * @param string $zoneId Zone Identifier.
     * @param string $pageRuleId Page Rule ID to overwrite.
     *
     * @return CloudFlareResponse Overwrite Page Rule response
     */
    public function overwrite(string $zoneId, string $pageRuleId, array $values): CloudFlareResponse
    {
        $this->requiredParams(['actions', 'targets'], $values);

        return $this->getHttpClient()->put("/zones/{$zoneId}/pagerules/{$pageRuleId}", $values);
    }

    /**
     * Delete a Page Rule
     *
     * @link https://developers.cloudflare.com/api/operations/page-rules-delete-a-page-rule
     *
     * @param string $zoneId Zone Identifier.
     * @param string $pageRuleId Page Rule ID to delete.
     *
     * @return CloudFlareResponse Delete a Page Rule response
     */
    public function delete(string $zoneId, string $pageRuleId): CloudFlareResponse
    {
        return $this->getHttpClient()->delete("/zones/{$zoneId}/pagerules/{$pageRuleId}");
    }
}
