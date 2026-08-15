<?php

namespace Cloudflare\Endpoints;

use Cloudflare\Contracts\ResponseInterface;

/**
 * User Agent Blocking rules: match requests by their `User-Agent` header and
 * act on them, per zone.
 *
 * @link https://developers.cloudflare.com/waf/tools/user-agent-blocking/
 */
class UserAgentRules extends AbstractEndpoint
{
    /**
     * Fetch User Agent Blocking rules in a zone.
     *
     * @link https://developers.cloudflare.com/api/operations/user-agent-blocking-rules-list-user-agent-blocking-rules
     *
     * @param string $zoneId Zone Identifier.
     * @param array $params Query Parameters: `description`, `user_agent`, `paused`, `page` and `per_page`.
     *
     * @return \Cloudflare\Contracts\ResponseInterface List User Agent Blocking rules response
     */
    public function list(string $zoneId, array $params = []): ResponseInterface
    {
        return $this->getHttpClient()->get("/zones/{$zoneId}/firewall/ua_rules", $params);
    }

    /**
     * Create a new User Agent Blocking rule in a zone.
     *
     * ```php
     * $client->userAgentRules()->create('ZONE_ID', [
     *     'mode' => 'block',
     *     'configuration' => ['target' => 'ua', 'value' => 'BadCrawler/1.0'],
     *     'description' => 'Block a misbehaving crawler',
     * ]);
     * ```
     *
     * @link https://developers.cloudflare.com/api/operations/user-agent-blocking-rules-create-a-user-agent-blocking-rule
     *
     * @param string $zoneId Zone Identifier.
     * @param array $values `mode`, one of `block`, `challenge`, `whitelist`, `js_challenge` or `managed_challenge`, and `configuration` with its `target` and `value`. `description` and `paused` are optional.
     *
     * @throws \Cloudflare\Exceptions\MissingArgumentException
     *
     * @return \Cloudflare\Contracts\ResponseInterface Create a User Agent Blocking rule response
     */
    public function create(string $zoneId, array $values): ResponseInterface
    {
        $this->requiredParams(['mode', 'configuration'], $values);

        return $this->getHttpClient()->post("/zones/{$zoneId}/firewall/ua_rules", $values);
    }

    /**
     * Fetch the details of a User Agent Blocking rule.
     *
     * @link https://developers.cloudflare.com/api/operations/user-agent-blocking-rules-get-a-user-agent-blocking-rule
     *
     * @param string $zoneId Zone Identifier.
     * @param string $ruleId User Agent Blocking rule Identifier.
     *
     * @return \Cloudflare\Contracts\ResponseInterface User Agent Blocking rule details response
     */
    public function get(string $zoneId, string $ruleId): ResponseInterface
    {
        return $this->getHttpClient()->get("/zones/{$zoneId}/firewall/ua_rules/{$ruleId}");
    }

    /**
     * Update an existing User Agent Blocking rule, overwriting the full configuration.
     *
     * Cloudflare wants the rule's `id` in the body as well as in the path, so
     * it is filled in from `$ruleId` unless `$values` carries one already.
     *
     * @link https://developers.cloudflare.com/api/operations/user-agent-blocking-rules-update-a-user-agent-blocking-rule
     *
     * @param string $zoneId Zone Identifier.
     * @param string $ruleId User Agent Blocking rule Identifier.
     * @param array $values `mode` and `configuration` are required, with `description` and `paused` optional.
     *
     * @throws \Cloudflare\Exceptions\MissingArgumentException
     *
     * @return \Cloudflare\Contracts\ResponseInterface Update a User Agent Blocking rule response
     */
    public function update(string $zoneId, string $ruleId, array $values): ResponseInterface
    {
        $this->requiredParams(['mode', 'configuration'], $values);

        return $this->getHttpClient()->put("/zones/{$zoneId}/firewall/ua_rules/{$ruleId}", array_merge([
            'id' => $ruleId,
        ], $values));
    }

    /**
     * Delete an existing User Agent Blocking rule.
     *
     * @link https://developers.cloudflare.com/api/operations/user-agent-blocking-rules-delete-a-user-agent-blocking-rule
     *
     * @param string $zoneId Zone Identifier.
     * @param string $ruleId User Agent Blocking rule Identifier.
     *
     * @return \Cloudflare\Contracts\ResponseInterface Delete a User Agent Blocking rule response
     */
    public function delete(string $zoneId, string $ruleId): ResponseInterface
    {
        return $this->getHttpClient()->delete("/zones/{$zoneId}/firewall/ua_rules/{$ruleId}");
    }
}
