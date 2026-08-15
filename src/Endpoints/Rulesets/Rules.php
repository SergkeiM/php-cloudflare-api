<?php

namespace Cloudflare\Endpoints\Rulesets;

use Cloudflare\Endpoints\AbstractEndpoint;
use Cloudflare\Contracts\ResponseInterface;
use Cloudflare\Configurations\Rules\Rule;

class Rules extends AbstractEndpoint
{
    /**
     * Adds a new rule to a ruleset.
     *
     * @link https://developers.cloudflare.com/api/resources/rulesets/subresources/rules/methods/create/
     *
     * @param string|null $accountId Account Identifier. Provide exactly one of $accountId or $zoneId.
     * @param string|null $zoneId Zone Identifier. Provide exactly one of $accountId or $zoneId.
     * @param string $rulesetId Ruleset Identifier.
     * @param array|\Cloudflare\Configurations\Rules\Rule $values A rule object.
     *
     * @return ResponseInterface A ruleset response.
     */
    public function create(?string $accountId, ?string $zoneId, string $rulesetId, array|Rule $values): ResponseInterface
    {
        if (is_array($values)) {
            //$this->requiredParams(['name', 'kind', 'phase', 'rules'], $values);
        } else {
            $values = $values->toArray();
        }

        return $this->getHttpClient()->post("{$this->scopePath($accountId, $zoneId)}/rulesets/{$rulesetId}/rules", $values);
    }

    /**
     * Updates an existing rule in a ruleset, creating a new version of the ruleset.
     *
     * @link https://developers.cloudflare.com/api/resources/rulesets/subresources/rules/methods/edit/
     *
     * @param string|null $accountId Account Identifier. Provide exactly one of $accountId or $zoneId.
     * @param string|null $zoneId Zone Identifier. Provide exactly one of $accountId or $zoneId.
     * @param string $rulesetId Ruleset Identifier.
     * @param string $ruleId Rule Identifier.
     * @param array|\Cloudflare\Configurations\Rules\Rule $values A rule object.
     *
     * @return ResponseInterface A ruleset response.
     */
    public function update(?string $accountId, ?string $zoneId, string $rulesetId, string $ruleId, array|Rule $values): ResponseInterface
    {
        if ($values instanceof Rule) {
            $values = $values->toArray();
        }

        return $this->getHttpClient()->patch("{$this->scopePath($accountId, $zoneId)}/rulesets/{$rulesetId}/rules/{$ruleId}", $values);
    }

    /**
     * Deletes an existing rule from a ruleset, creating a new version of the ruleset.
     *
     * @link https://developers.cloudflare.com/api/resources/rulesets/subresources/rules/methods/delete/
     *
     * @param string|null $accountId Account Identifier. Provide exactly one of $accountId or $zoneId.
     * @param string|null $zoneId Zone Identifier. Provide exactly one of $accountId or $zoneId.
     * @param string $rulesetId Ruleset Identifier.
     * @param string $ruleId Rule Identifier.
     *
     * @return ResponseInterface A ruleset response.
     */
    public function delete(?string $accountId, ?string $zoneId, string $rulesetId, string $ruleId): ResponseInterface
    {
        return $this->getHttpClient()->delete("{$this->scopePath($accountId, $zoneId)}/rulesets/{$rulesetId}/rules/{$ruleId}");
    }
}
