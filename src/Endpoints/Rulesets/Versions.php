<?php

namespace Cloudflare\Endpoints\Rulesets;

use Cloudflare\Endpoints\AbstractEndpoint;
use Cloudflare\Contracts\ResponseInterface;

/**
 * Every change to a ruleset creates a new version of it, and the old versions
 * stay readable — useful for seeing what a ruleset looked like before a change,
 * or for recovering a rule that was removed.
 *
 * A ruleset is scoped to either an account or a zone: pass exactly one
 * of $accountId or $zoneId.
 */
class Versions extends AbstractEndpoint
{
    /**
     * Fetches the versions of a ruleset.
     *
     * @link https://developers.cloudflare.com/api/resources/rulesets/subresources/versions/methods/list/
     *
     * @param string|null $accountId Account Identifier. Provide exactly one of $accountId or $zoneId.
     * @param string|null $zoneId Zone Identifier. Provide exactly one of $accountId or $zoneId.
     * @param string $rulesetId Ruleset Identifier.
     *
     * @return ResponseInterface A rulesets response.
     */
    public function list(?string $accountId, ?string $zoneId, string $rulesetId): ResponseInterface
    {
        return $this->getHttpClient()->get("{$this->scopePath($accountId, $zoneId)}/rulesets/{$rulesetId}/versions");
    }

    /**
     * Fetches a specific version of a ruleset.
     *
     * @link https://developers.cloudflare.com/api/resources/rulesets/subresources/versions/methods/get/
     *
     * @param string|null $accountId Account Identifier. Provide exactly one of $accountId or $zoneId.
     * @param string|null $zoneId Zone Identifier. Provide exactly one of $accountId or $zoneId.
     * @param string $rulesetId Ruleset Identifier.
     * @param string $version Version of the ruleset.
     *
     * @return ResponseInterface A ruleset response.
     */
    public function get(?string $accountId, ?string $zoneId, string $rulesetId, string $version): ResponseInterface
    {
        return $this->getHttpClient()->get("{$this->scopePath($accountId, $zoneId)}/rulesets/{$rulesetId}/versions/{$version}");
    }

    /**
     * Deletes an existing version of a ruleset.
     *
     * @link https://developers.cloudflare.com/api/resources/rulesets/subresources/versions/methods/delete/
     *
     * @param string|null $accountId Account Identifier. Provide exactly one of $accountId or $zoneId.
     * @param string|null $zoneId Zone Identifier. Provide exactly one of $accountId or $zoneId.
     * @param string $rulesetId Ruleset Identifier.
     * @param string $version Version of the ruleset.
     *
     * @return ResponseInterface An empty response.
     */
    public function delete(?string $accountId, ?string $zoneId, string $rulesetId, string $version): ResponseInterface
    {
        return $this->getHttpClient()->delete("{$this->scopePath($accountId, $zoneId)}/rulesets/{$rulesetId}/versions/{$version}");
    }

    /**
     * Fetches the rules of a ruleset version that carry a given tag, such as
     * `wordpress` or the CVE a managed rule addresses.
     *
     * @param string|null $accountId Account Identifier. Provide exactly one of $accountId or $zoneId.
     * @param string|null $zoneId Zone Identifier. Provide exactly one of $accountId or $zoneId.
     * @param string $rulesetId Ruleset Identifier.
     * @param string $version Version of the ruleset.
     * @param string $tag Tag the rules carry.
     *
     * @return ResponseInterface A ruleset response.
     */
    public function byTag(?string $accountId, ?string $zoneId, string $rulesetId, string $version, string $tag): ResponseInterface
    {
        return $this->getHttpClient()->get("{$this->scopePath($accountId, $zoneId)}/rulesets/{$rulesetId}/versions/{$version}/by_tag/{$tag}");
    }
}
