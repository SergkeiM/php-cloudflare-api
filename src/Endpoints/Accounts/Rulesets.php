<?php

namespace Cloudflare\Endpoints\Accounts;

use Cloudflare\Endpoints\AbstractEndpoint;
use Cloudflare\Contracts\ResponseInterface;
use Cloudflare\Configurations\Ruleset;

class Rulesets extends AbstractEndpoint
{
    /**
     * Fetches all rulesets at the account level.
     *
     * @link https://developers.cloudflare.com/api/operations/listAccountRulesets
     *
     * @param string $accountId Account Identifier.
     *
     * @return \Cloudflare\Contracts\ResponseInterface A rulesets response.
     */
    public function get(string $accountId): ResponseInterface
    {
        return $this->getHttpClient()->get("/accounts/{$accountId}/rulesets");
    }

    /**
     * Creates a ruleset at the account level.
     *
     * @link https://developers.cloudflare.com/api/operations/createAccountRuleset
     *
     * @param string $accountId Account Identifier.
     * @param array|\Cloudflare\Configurations\Ruleset $values A ruleset object.
     *
     * @return \Cloudflare\Contracts\ResponseInterface A ruleset response.
     */
    public function create(string $accountId, array|Ruleset $values): ResponseInterface
    {
        if(is_array($values)) {
            $this->requiredParams(['name', 'kind', 'phase', 'rules'], $values);
        } else {
            $values = $values->toArray();
        }

        return $this->getHttpClient()->post("/accounts/{$accountId}/rulesets", $values);
    }

    /**
     * Fetches the latest version of an account ruleset.
     *
     * @link https://developers.cloudflare.com/api/operations/getAccountRuleset
     *
     * @param string $accountId Account Identifier.
     * @param string $rulesetId Ruleset Identifier.
     *
     * @return \Cloudflare\Contracts\ResponseInterface A ruleset response.
     */
    public function details(string $accountId, string $rulesetId): ResponseInterface
    {
        return $this->getHttpClient()->get("/accounts/{$accountId}/rulesets/{$rulesetId}");
    }

    /**
     * Deletes all versions of an existing account ruleset.
     *
     * @link https://developers.cloudflare.com/api/operations/deleteAccountRuleset
     *
     * @param string $accountId Account Identifier.
     * @param string $rulesetId Ruleset Identifier.
     *
     * @return \Cloudflare\Contracts\ResponseInterface An empty response.
     */
    public function delete(string $accountId, string $rulesetId): ResponseInterface
    {
        return $this->getHttpClient()->delete("/accounts/{$accountId}/rulesets/{$rulesetId}");
    }

}
