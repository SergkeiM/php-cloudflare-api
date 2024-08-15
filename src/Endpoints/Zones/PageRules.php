<?php

namespace SergkeiM\CloudFlare\Endpoints\Zones;

use SergkeiM\CloudFlare\Endpoints\AbstractEndpoint;
use SergkeiM\CloudFlare\Contracts\CloudFlareResponse;

class PageRules extends AbstractEndpoint
{
    /**
     * List Page Rules in a zone.
     *
     * @link https://developers.cloudflare.com/api/operations/page-rules-list-page-rules
     *
     * @param string $zoneId Zone ID to list DNS records.
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
     * @param string $zoneId Zone ID that you want to create a new Page Rule for.
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
     * @param string $zoneId Zone ID to fetch details.
     * @param string $pageruleId Page Rule ID to fetch details.
     *
     * @return CloudFlareResponse Get a Page Rule response
     */
    public function details(string $zoneId, string $pageruleId): CloudFlareResponse
    {
        return $this->getHttpClient()->get("/zones/{$zoneId}/pagerules/{$pageruleId}");
    }

    /**
     * Updates one or more fields of an existing Page Rule.
     *
     * @link https://developers.cloudflare.com/api/operations/page-rules-edit-a-page-rule
     *
     * @param string $zoneId Zone ID to update Page Rule on.
     * @param string $pageruleId Page Rule ID to update.
     *
     * @return CloudFlareResponse Edit a Page Rule response
     */
    public function update(string $zoneId, string $pageruleId, array $values): CloudFlareResponse
    {
        return $this->getHttpClient()->patch("/zones/{$zoneId}/pagerules/{$pageruleId}", $values);
    }

    /**
     * Replaces the configuration of an existing Page Rule. The configuration of the updated Page Rule will exactly match the data passed in the API request.
     *
     * @link https://developers.cloudflare.com/api/operations/page-rules-update-a-page-rule
     *
     * @param string $zoneId Zone ID to overwrite Page Rule on.
     * @param string $pageruleId Page Rule ID to overwrite.
     *
     * @return CloudFlareResponse Overwrite Page Rule response
     */
    public function overwrite(string $zoneId, string $pageruleId, array $values): CloudFlareResponse
    {
        $this->requiredParams(['actions', 'targets'], $values);

        return $this->getHttpClient()->put("/zones/{$zoneId}/pagerules/{$pageruleId}", $values);
    }

    /**
     * Delete a Page Rule
     *
     * @link https://developers.cloudflare.com/api/operations/page-rules-delete-a-page-rule
     *
     * @param string $zoneId Zone ID that you want to delete Page Rule for.
     * @param string $pageruleId Page Rule ID to delete.
     *
     * @return CloudFlareResponse Delete a Page Rule response
     */
    public function delete(string $zoneId, string $pageruleId): CloudFlareResponse
    {
        return $this->getHttpClient()->delete("/zones/{$zoneId}/pagerules/{$pageruleId}");
    }
}
