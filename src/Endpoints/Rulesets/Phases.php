<?php

namespace Cloudflare\Endpoints\Rulesets;

use Cloudflare\Endpoints\AbstractEndpoint;
use Cloudflare\Contracts\ResponseInterface;
use Cloudflare\Configurations\Ruleset;

/**
 * Each phase of the Ruleset Engine runs one entry point ruleset, which is where
 * your own rules for that phase live — `http_request_firewall_custom` for custom
 * firewall rules, `http_request_transform` for URL rewrites, and so on.
 *
 * The phase names the entry point, so it is addressed by phase rather than by
 * ruleset id. A phase is scoped to either an account or a zone: pass exactly one
 * of $accountId or $zoneId.
 *
 * @link https://developers.cloudflare.com/ruleset-engine/reference/phases-list/
 */
class Phases extends AbstractEndpoint
{
    /**
     * Fetches the latest version of the entry point ruleset for a phase.
     *
     * @link https://developers.cloudflare.com/api/resources/rulesets/subresources/phases/methods/get/
     *
     * @param string|null $accountId Account Identifier. Provide exactly one of $accountId or $zoneId.
     * @param string|null $zoneId Zone Identifier. Provide exactly one of $accountId or $zoneId.
     * @param string $phase The phase of the ruleset, e.g. `http_request_firewall_custom`.
     *
     * @return ResponseInterface A ruleset response.
     */
    public function get(?string $accountId, ?string $zoneId, string $phase): ResponseInterface
    {
        return $this->getHttpClient()->get("{$this->scopePath($accountId, $zoneId)}/rulesets/phases/{$phase}/entrypoint");
    }

    /**
     * Updates the entry point ruleset for a phase, creating it if the phase has
     * none yet.
     *
     * The rules given replace the ones the entry point holds, so send the full
     * set, not just the ones that changed.
     *
     * @link https://developers.cloudflare.com/api/resources/rulesets/subresources/phases/methods/update/
     *
     * @param string|null $accountId Account Identifier. Provide exactly one of $accountId or $zoneId.
     * @param string|null $zoneId Zone Identifier. Provide exactly one of $accountId or $zoneId.
     * @param string $phase The phase of the ruleset, e.g. `http_request_firewall_custom`.
     * @param array|\Cloudflare\Configurations\Ruleset $values A ruleset object.
     *
     * @return ResponseInterface A ruleset response.
     */
    public function update(?string $accountId, ?string $zoneId, string $phase, array|Ruleset $values): ResponseInterface
    {
        if ($values instanceof Ruleset) {
            $values = $values->toArray();

            // The URL names the phase, and an entry point is always a zone or
            // account ruleset, so neither belongs in the body.
            unset($values['phase'], $values['kind']);
        }

        return $this->getHttpClient()->put("{$this->scopePath($accountId, $zoneId)}/rulesets/phases/{$phase}/entrypoint", $values);
    }

    /**
     * Fetches the versions of the entry point ruleset for a phase.
     *
     * @link https://developers.cloudflare.com/api/resources/rulesets/subresources/phases/subresources/versions/methods/list/
     *
     * @param string|null $accountId Account Identifier. Provide exactly one of $accountId or $zoneId.
     * @param string|null $zoneId Zone Identifier. Provide exactly one of $accountId or $zoneId.
     * @param string $phase The phase of the ruleset, e.g. `http_request_firewall_custom`.
     *
     * @return ResponseInterface A rulesets response.
     */
    public function versions(?string $accountId, ?string $zoneId, string $phase): ResponseInterface
    {
        return $this->getHttpClient()->get("{$this->scopePath($accountId, $zoneId)}/rulesets/phases/{$phase}/entrypoint/versions");
    }

    /**
     * Fetches a specific version of the entry point ruleset for a phase.
     *
     * @link https://developers.cloudflare.com/api/resources/rulesets/subresources/phases/subresources/versions/methods/get/
     *
     * @param string|null $accountId Account Identifier. Provide exactly one of $accountId or $zoneId.
     * @param string|null $zoneId Zone Identifier. Provide exactly one of $accountId or $zoneId.
     * @param string $phase The phase of the ruleset, e.g. `http_request_firewall_custom`.
     * @param string $version Version of the ruleset.
     *
     * @return ResponseInterface A ruleset response.
     */
    public function version(?string $accountId, ?string $zoneId, string $phase, string $version): ResponseInterface
    {
        return $this->getHttpClient()->get("{$this->scopePath($accountId, $zoneId)}/rulesets/phases/{$phase}/entrypoint/versions/{$version}");
    }
}
