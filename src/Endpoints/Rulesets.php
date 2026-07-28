<?php

namespace Cloudflare\Endpoints;

use Cloudflare\Contracts\ResponseInterface;
use Cloudflare\Configurations\Ruleset;
use Cloudflare\Endpoints\Rulesets\Rules;

/**
 * The Cloudflare Ruleset Engine allows you to create and deploy rules and
 * rulesets in different Cloudflare products using the same basic syntax.
 * A ruleset is scoped to either an account or a zone: pass exactly one
 * of $accountId or $zoneId.
 */
class Rulesets extends AbstractEndpoint
{
    /**
     * Fetches all rulesets.
     *
     * @link https://developers.cloudflare.com/api/operations/listAccountRulesets
     *
     * @param string|null $accountId Account Identifier. Provide exactly one of $accountId or $zoneId.
     * @param string|null $zoneId Zone Identifier. Provide exactly one of $accountId or $zoneId.
     *
     * @return ResponseInterface A rulesets response.
     */
    public function list(?string $accountId = null, ?string $zoneId = null): ResponseInterface
    {
        return $this->getHttpClient()->get("{$this->scopePath($accountId, $zoneId)}/rulesets");
    }

    /**
     * Creates a ruleset.
     *
     * @link https://developers.cloudflare.com/api/operations/createAccountRuleset
     *
     * @param string|null $accountId Account Identifier. Provide exactly one of $accountId or $zoneId.
     * @param string|null $zoneId Zone Identifier. Provide exactly one of $accountId or $zoneId.
     * @param array|\Cloudflare\Configurations\Ruleset $values A ruleset object.
     *
     * @return ResponseInterface A ruleset response.
     */
    public function create(?string $accountId, ?string $zoneId, array|Ruleset $values): ResponseInterface
    {
        if (is_array($values)) {
            $this->requiredParams(['name', 'kind', 'phase'], $values);
        } else {
            $values = $values->toArray();
        }

        return $this->getHttpClient()->post("{$this->scopePath($accountId, $zoneId)}/rulesets", $values);
    }

    /**
     * Fetches the latest version of a ruleset.
     *
     * @link https://developers.cloudflare.com/api/operations/getAccountRuleset
     *
     * @param string|null $accountId Account Identifier. Provide exactly one of $accountId or $zoneId.
     * @param string|null $zoneId Zone Identifier. Provide exactly one of $accountId or $zoneId.
     * @param string $rulesetId Ruleset Identifier.
     *
     * @return ResponseInterface A ruleset response.
     */
    public function get(?string $accountId, ?string $zoneId, string $rulesetId): ResponseInterface
    {
        return $this->getHttpClient()->get("{$this->scopePath($accountId, $zoneId)}/rulesets/{$rulesetId}");
    }

    /**
     * Deletes all versions of an existing ruleset.
     *
     * @link https://developers.cloudflare.com/api/operations/deleteAccountRuleset
     *
     * @param string|null $accountId Account Identifier. Provide exactly one of $accountId or $zoneId.
     * @param string|null $zoneId Zone Identifier. Provide exactly one of $accountId or $zoneId.
     * @param string $rulesetId Ruleset Identifier.
     *
     * @return ResponseInterface An empty response.
     */
    public function delete(?string $accountId, ?string $zoneId, string $rulesetId): ResponseInterface
    {
        return $this->getHttpClient()->delete("{$this->scopePath($accountId, $zoneId)}/rulesets/{$rulesetId}");
    }

    /**
     * Ruleset Rules
     *
     * @return \Cloudflare\Endpoints\Rulesets\Rules
     */
    public function rules(): Rules
    {
        return new Rules($this->getClient());
    }
}
