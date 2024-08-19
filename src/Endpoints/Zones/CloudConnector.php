<?php

namespace Cloudflare\Endpoints\Zones;

use Cloudflare\Endpoints\AbstractEndpoint;
use Cloudflare\Contracts\CloudflareResponse;

class CloudConnector extends AbstractEndpoint
{
    /**
     * @link https://developers.cloudflare.com/api/operations/zone-cloud-connector-rules
     *
     * @param string $zoneId Zone Identifier.
     *
     * @return CloudflareResponse Cloud Connector rules response.
     */
    public function get(string $zoneId): CloudflareResponse
    {
        return $this->getHttpClient()->get("/zones/{$zoneId}/cloud_connector/rules");
    }

    /**
     * @link https://developers.cloudflare.com/api/operations/zone-cloud-conenctor-rules-put
     *
     * @param string $zoneId Zone Identifier.
     * @param array $values List of Cloud Connector rules.
     *
     * @return CloudflareResponse Cloud Connector rules response.
     */
    public function update(string $zoneId, array $values): CloudflareResponse
    {

        $this->requiredParams(['name'], $values);

        return $this->getHttpClient()->put("/zones/{$zoneId}/cloud_connector/rules", $values);
    }
}
