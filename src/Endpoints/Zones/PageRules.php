<?php

namespace CloudFlare\Endpoints\Zones;

use CloudFlare\Endpoints\AbstractEndpoint;
use CloudFlare\Contracts\CloudFlareResponse;
use CloudFlare\Configurations\Zones\PageRule;

class PageRules extends AbstractEndpoint
{
    /**
     * Returns a list of settings (and their details) that Page Rules can apply to matching requests.
     *
     * @link https://developers.cloudflare.com/api/operations/available-page-rules-settings-list-available-page-rules-settings
     *
     * @param string $zoneId Zone Identifier.
     *
     * @return \CloudFlare\Contracts\CloudFlareResponse List available Page Rules settings response
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
     * @return \CloudFlare\Contracts\CloudFlareResponse List Page Rules response
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
     * @param array|\CloudFlare\Configurations\Zones\PageRule $values Values to set on Page Rule.
     *
     * @return \CloudFlare\Contracts\CloudFlareResponse Create a Page Rule response
     */
    public function create(string $zoneId, array|PageRule $values): CloudFlareResponse
    {
        if(is_array($values)) {
            $this->requiredParams(['actions', 'targets'], $values);
        } else {
            $values = $values->toArray();
        }

        return $this->$this->getHttpClient()->post("/zones/{$zoneId}/pagerules", $values);
    }

    /**
     * Fetches the details of a Page Rule.
     *
     * @link https://developers.cloudflare.com/api/operations/page-rules-get-a-page-rule
     *
     * @param string $zoneId Zone Identifier.
     * @param string $pageRuleId Page Rule Identifier.
     *
     * @return \CloudFlare\Contracts\CloudFlareResponse Get a Page Rule response
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
     * @param string $pageRuleId Page Rule Identifier.
     * @param array|\CloudFlare\Contracts\Configuration $values Values to set on Page Rule.
     *
     * @return \CloudFlare\Contracts\CloudFlareResponse Edit a Page Rule response
     */
    public function update(string $zoneId, string $pageRuleId, array|Configuration $values): CloudFlareResponse
    {
        if(is_array($values)) {
            $this->requiredParams(['actions', 'targets'], $values);
        } else {
            $values = $values->toArray();
        }

        return $this->getHttpClient()->patch("/zones/{$zoneId}/pagerules/{$pageRuleId}", $values);
    }

    /**
     * Replaces the configuration of an existing Page Rule. The configuration of the updated Page Rule will exactly match the data passed in the API request.
     *
     * @link https://developers.cloudflare.com/api/operations/page-rules-update-a-page-rule
     *
     * @param string $zoneId Zone Identifier.
     * @param string $pageRuleId Page Rule Identifier.
     * @param array|\CloudFlare\Contracts\Configuration $values Values to set on Page Rule.
     *
     * @return \CloudFlare\Contracts\CloudFlareResponse Overwrite Page Rule response
     */
    public function overwrite(string $zoneId, string $pageRuleId, Configuration|array $values): CloudFlareResponse
    {
        if(is_array($values)) {
            $this->requiredParams(['actions', 'targets'], $values);
        } else {
            $values = $values->toArray();
        }

        return $this->getHttpClient()->put("/zones/{$zoneId}/pagerules/{$pageRuleId}", $values);
    }

    /**
     * Delete a Page Rule
     *
     * @link https://developers.cloudflare.com/api/operations/page-rules-delete-a-page-rule
     *
     * @param string $zoneId Zone Identifier.
     * @param string $pageRuleId Page Rule Identifier.
     *
     * @return \CloudFlare\Contracts\CloudFlareResponse Delete a Page Rule response
     */
    public function delete(string $zoneId, string $pageRuleId): CloudFlareResponse
    {
        return $this->getHttpClient()->delete("/zones/{$zoneId}/pagerules/{$pageRuleId}");
    }
}
