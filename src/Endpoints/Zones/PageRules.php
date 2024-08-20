<?php

namespace Cloudflare\Endpoints\Zones;

use Cloudflare\Endpoints\AbstractEndpoint;
use Cloudflare\Contracts\ResponseInterface;
use Cloudflare\Configurations\Zones\PageRule;

class PageRules extends AbstractEndpoint
{
    /**
     * Returns a list of settings (and their details) that Page Rules can apply to matching requests.
     *
     * @link https://developers.cloudflare.com/api/operations/available-page-rules-settings-list-available-page-rules-settings
     *
     * @param string $zoneId Zone Identifier.
     *
     * @return \Cloudflare\Contracts\ResponseInterface List available Page Rules settings response
     */
    public function settings(string $zoneId): ResponseInterface
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
     * @return \Cloudflare\Contracts\ResponseInterface List Page Rules response
     */
    public function list(string $zoneId, array $params = []): ResponseInterface
    {
        return $this->getHttpClient()->get("/zones/{$zoneId}/pagerules", $params);
    }

    /**
     * Create a Page Rule
     *
     * @link https://developers.cloudflare.com/api/operations/page-rules-create-a-page-rule
     *
     * @param string $zoneId Zone Identifier.
     * @param array|\Cloudflare\Configurations\Zones\PageRule $values Values to set on Page Rule.
     *
     * @return \Cloudflare\Contracts\ResponseInterface Create a Page Rule response
     */
    public function create(string $zoneId, array|PageRule $values): ResponseInterface
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
     * @return \Cloudflare\Contracts\ResponseInterface Get a Page Rule response
     */
    public function details(string $zoneId, string $pageRuleId): ResponseInterface
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
     * @param array|\Cloudflare\Configurations\Zones\PageRule $values Values to set on Page Rule.
     *
     * @return \Cloudflare\Contracts\ResponseInterface Edit a Page Rule response
     */
    public function update(string $zoneId, string $pageRuleId, array|PageRule $values): ResponseInterface
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
     * @param array|\Cloudflare\Configurations\Zones\PageRule $values Values to set on Page Rule.
     *
     * @return \Cloudflare\Contracts\ResponseInterface Overwrite Page Rule response
     */
    public function overwrite(string $zoneId, string $pageRuleId, PageRule|array $values): ResponseInterface
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
     * @return \Cloudflare\Contracts\ResponseInterface Delete a Page Rule response
     */
    public function delete(string $zoneId, string $pageRuleId): ResponseInterface
    {
        return $this->getHttpClient()->delete("/zones/{$zoneId}/pagerules/{$pageRuleId}");
    }
}
