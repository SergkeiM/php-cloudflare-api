<?php

namespace Cloudflare\Endpoints\Zones;

use Cloudflare\Endpoints\AbstractEndpoint;
use Cloudflare\Contracts\ResponseInterface;
use Cloudflare\Configurations\Ruleset;

class Rulesets extends AbstractEndpoint
{
    /**
     * List zone rulesets
     *
     * @link https://developers.cloudflare.com/api/operations/listZoneRulesets
     *
     * @param string $zoneId Zone Identifier.
     *
     * @return \Cloudflare\Contracts\ResponseInterface A rulesets response.
     */
    public function get(string $zoneId): ResponseInterface
    {
        return $this->getHttpClient()->get("/zones/{$zoneId}/rulesets");
    }

    /**
     * Creates a ruleset at the zone level.
     *
     * @link https://developers.cloudflare.com/api/operations/createZoneRuleset
     *
     * @param string $zoneId Zone Identifier.
     * @param array|\Cloudflare\Configurations\Ruleset $values A ruleset object.
     *
     * @return \Cloudflare\Contracts\ResponseInterface A ruleset response.
     */
    public function create(string $zoneId, array|Ruleset $values): ResponseInterface
    {
        if(is_array($values)) {
            $this->requiredParams(['name', 'kind', 'phase', 'rules'], $values);
        } else {
            $values = $values->toArray();
        }

        return $this->getHttpClient()->post("/zones/{$zoneId}/rulesets", $values);
    }

    /**
     * Fetches the latest version of a zone ruleset.
     *
     * @link https://developers.cloudflare.com/api/operations/getZoneRuleset
     *
     * @param string $zoneId Zone Identifier.
     * @param string $rulesetId Ruleset Identifier.
     *
     * @return \Cloudflare\Contracts\ResponseInterface A ruleset response.
     */
    public function details(string $zoneId, string $rulesetId): ResponseInterface
    {
        return $this->getHttpClient()->get("/zones/{$zoneId}/rulesets/{$rulesetId}");
    }

    /**
     * Deletes all versions of an existing zone ruleset.
     *
     * @link https://developers.cloudflare.com/api/operations/deleteZoneRuleset
     *
     * @param string $zoneId Zone Identifier.
     * @param string $rulesetId Ruleset Identifier.
     *
     * @return \Cloudflare\Contracts\ResponseInterface An empty response.
     */
    public function delete(string $zoneId, string $rulesetId): ResponseInterface
    {
        return $this->getHttpClient()->delete("/zones/{$zoneId}/rulesets/{$rulesetId}");
    }

}
