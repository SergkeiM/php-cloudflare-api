<?php

namespace Cloudflare\Endpoints;

use Cloudflare\Contracts\ResponseInterface;

class AccessRules extends AbstractEndpoint
{
    /**
     * List, search, sort, and filter a zone's IP Access rules.
     *
     * @link https://developers.cloudflare.com/api/operations/ip-access-rules-for-a-zone-list-ip-access-rules
     *
     * @param string $zoneId Zone Identifier.
     * @param array $params Query Parameters.
     *
     * @return ResponseInterface List IP Access rules response
     */
    public function list(string $zoneId, array $params = []): ResponseInterface
    {
        return $this->getHttpClient()->get("/zones/{$zoneId}/firewall/access_rules/rules", $params);
    }

    /**
     * Create a new IP Access rule for a zone.
     *
     * @link https://developers.cloudflare.com/api/operations/ip-access-rules-for-a-zone-create-an-ip-access-rule
     *
     * @param string $zoneId Zone Identifier.
     * @param array $values Values to set on the IP Access rule, e.g. `mode`, `configuration` (`target`, `value`), `notes`.
     *
     * @return ResponseInterface Create an IP Access rule response
     */
    public function create(string $zoneId, array $values): ResponseInterface
    {
        $this->requiredParams(['mode', 'configuration'], $values);

        return $this->getHttpClient()->post("/zones/{$zoneId}/firewall/access_rules/rules", $values);
    }

    /**
     * Apply changes to an existing IP Access rule for a zone, overwriting only the supplied properties.
     *
     * @link https://developers.cloudflare.com/api/operations/ip-access-rules-for-a-zone-update-an-ip-access-rule
     *
     * @param string $zoneId Zone Identifier.
     * @param string $ruleId IP Access Rule Identifier.
     * @param array $values Values to set on the IP Access rule, e.g. `mode`, `notes`.
     *
     * @return ResponseInterface Edit an IP Access rule response
     */
    public function edit(string $zoneId, string $ruleId, array $values): ResponseInterface
    {
        return $this->getHttpClient()->patch("/zones/{$zoneId}/firewall/access_rules/rules/{$ruleId}", $values);
    }

    /**
     * Delete an IP Access rule for a zone.
     *
     * @link https://developers.cloudflare.com/api/operations/ip-access-rules-for-a-zone-delete-an-ip-access-rule
     *
     * @param string $zoneId Zone Identifier.
     * @param string $ruleId IP Access Rule Identifier.
     *
     * @return ResponseInterface Delete an IP Access rule response
     */
    public function delete(string $zoneId, string $ruleId): ResponseInterface
    {
        return $this->getHttpClient()->delete("/zones/{$zoneId}/firewall/access_rules/rules/{$ruleId}");
    }
}
