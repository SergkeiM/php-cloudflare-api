<?php

namespace Cloudflare\Endpoints\Accounts;

use Cloudflare\Endpoints\AbstractEndpoint;
use Cloudflare\Contracts\ResponseInterface;

/**
 * IP Access rules defined at the account level, applying to every zone in the
 * account.
 *
 * Cloudflare exposes the same resource at three scopes: `$client->firewall()->accessRules()`
 * for a single zone, this one for an account, and
 * `$client->user()->accessRules()` for every zone the authenticated user owns.
 *
 * @link https://developers.cloudflare.com/waf/tools/ip-access-rules/
 */
class AccessRules extends AbstractEndpoint
{
    /**
     * List, search, sort and filter an account's IP Access rules.
     *
     * @link https://developers.cloudflare.com/api/resources/firewall/subresources/access_rules/methods/list/
     *
     * @param string $accountId Account Identifier.
     * @param array $params Query Parameters: `mode`, `configuration.target`, `configuration.value`, `notes`, `match`, `page`, `per_page`, `order` and `direction`.
     *
     * @return ResponseInterface List IP Access rules response
     */
    public function list(string $accountId, array $params = []): ResponseInterface
    {
        return $this->getHttpClient()->get("/accounts/{$accountId}/firewall/access_rules/rules", $params);
    }

    /**
     * Create an IP Access rule for every zone in an account.
     *
     * ```php
     * $client->accounts()->accessRules()->create('ACCOUNT_ID', [
     *     'mode' => 'block',
     *     'configuration' => ['target' => 'ip', 'value' => '198.51.100.4'],
     *     'notes' => 'Blocked for abuse',
     * ]);
     * ```
     *
     * @link https://developers.cloudflare.com/api/resources/firewall/subresources/access_rules/methods/create/
     *
     * @param string $accountId Account Identifier.
     * @param array $values `mode`, one of `block`, `challenge`, `whitelist`, `js_challenge` or `managed_challenge`, and `configuration` with its `target` (`ip`, `ip_range`, `asn` or `country`) and `value`. `notes` is optional.
     *
     * @throws \Cloudflare\Exceptions\MissingArgumentException
     *
     * @return ResponseInterface Create an IP Access rule response
     */
    public function create(string $accountId, array $values): ResponseInterface
    {
        $this->requiredParams(['mode', 'configuration'], $values);

        return $this->getHttpClient()->post("/accounts/{$accountId}/firewall/access_rules/rules", $values);
    }

    /**
     * Get a single IP Access rule defined at the account level.
     *
     * @link https://developers.cloudflare.com/api/resources/firewall/subresources/access_rules/methods/get/
     *
     * @param string $accountId Account Identifier.
     * @param string $ruleId IP Access Rule Identifier.
     *
     * @return ResponseInterface IP Access rule details response
     */
    public function get(string $accountId, string $ruleId): ResponseInterface
    {
        return $this->getHttpClient()->get("/accounts/{$accountId}/firewall/access_rules/rules/{$ruleId}");
    }

    /**
     * Apply changes to an IP Access rule, overwriting only the supplied properties.
     *
     * @link https://developers.cloudflare.com/api/resources/firewall/subresources/access_rules/methods/edit/
     *
     * @param string $accountId Account Identifier.
     * @param string $ruleId IP Access Rule Identifier.
     * @param array $values Values to set on the IP Access rule, e.g. `mode`, `notes`.
     *
     * @return ResponseInterface Edit an IP Access rule response
     */
    public function edit(string $accountId, string $ruleId, array $values): ResponseInterface
    {
        return $this->getHttpClient()->patch("/accounts/{$accountId}/firewall/access_rules/rules/{$ruleId}", $values);
    }

    /**
     * Delete an IP Access rule defined at the account level.
     *
     * @link https://developers.cloudflare.com/api/resources/firewall/subresources/access_rules/methods/delete/
     *
     * @param string $accountId Account Identifier.
     * @param string $ruleId IP Access Rule Identifier.
     *
     * @return ResponseInterface Delete an IP Access rule response
     */
    public function delete(string $accountId, string $ruleId): ResponseInterface
    {
        return $this->getHttpClient()->delete("/accounts/{$accountId}/firewall/access_rules/rules/{$ruleId}");
    }
}
