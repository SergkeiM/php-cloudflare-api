<?php

namespace Cloudflare\Endpoints;

use Cloudflare\Contracts\ResponseInterface;
use Cloudflare\Configurations\Ruleset;
use Cloudflare\Endpoints\Rulesets\Phases;
use Cloudflare\Endpoints\Rulesets\Rules;
use Cloudflare\Endpoints\Rulesets\Versions;

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
     * Updates a ruleset, creating a new version of it.
     *
     * The rules given replace the ones the ruleset holds, so send the full set,
     * not just the ones that changed.
     *
     * @link https://developers.cloudflare.com/api/resources/rulesets/methods/update/
     *
     * @param string|null $accountId Account Identifier. Provide exactly one of $accountId or $zoneId.
     * @param string|null $zoneId Zone Identifier. Provide exactly one of $accountId or $zoneId.
     * @param string $rulesetId Ruleset Identifier.
     * @param array|\Cloudflare\Configurations\Ruleset $values A ruleset object.
     *
     * @return ResponseInterface A ruleset response.
     */
    public function update(?string $accountId, ?string $zoneId, string $rulesetId, array|Ruleset $values): ResponseInterface
    {
        if ($values instanceof Ruleset) {
            $values = $values->toArray();
        }

        return $this->getHttpClient()->put("{$this->scopePath($accountId, $zoneId)}/rulesets/{$rulesetId}", $values);
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

    /**
     * Ruleset Versions
     *
     * @return \Cloudflare\Endpoints\Rulesets\Versions
     */
    public function versions(): Versions
    {
        return new Versions($this->getClient());
    }

    /**
     * Entry point rulesets, the ruleset a phase runs first.
     *
     * @return \Cloudflare\Endpoints\Rulesets\Phases
     */
    public function phases(): Phases
    {
        return new Phases($this->getClient());
    }
}
