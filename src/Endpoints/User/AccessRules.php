<?php

namespace Cloudflare\Endpoints\User;

use Cloudflare\Endpoints\AbstractEndpoint;
use Cloudflare\Contracts\ResponseInterface;

/**
 * IP Access rules defined at the user level, applying to every zone the
 * authenticated user owns.
 *
 * The zone-scoped counterpart is `$client->accessRules()`, which takes a zone
 * identifier and applies to that zone alone.
 *
 * @link https://developers.cloudflare.com/waf/tools/ip-access-rules/
 */
class AccessRules extends AbstractEndpoint
{
    /**
     * List, search, sort and filter the user's IP Access rules.
     *
     * @link https://developers.cloudflare.com/api/resources/user/subresources/firewall/
     *
     * @param array $params Query Parameters: `mode`, `configuration.target`, `configuration.value`, `notes`, `match`, `page`, `per_page`, `order` and `direction`.
     *
     * @return ResponseInterface List IP Access rules response
     */
    public function list(array $params = []): ResponseInterface
    {
        return $this->getHttpClient()->get('/user/firewall/access_rules/rules', $params);
    }

    /**
     * Create an IP Access rule for every zone the user owns.
     *
     * ```php
     * $client->user()->accessRules()->create([
     *     'mode' => 'block',
     *     'configuration' => ['target' => 'ip', 'value' => '198.51.100.4'],
     *     'notes' => 'Blocked for abuse',
     * ]);
     * ```
     *
     * @link https://developers.cloudflare.com/api/resources/user/subresources/firewall/
     *
     * @param array $values `mode`, one of `block`, `challenge`, `whitelist`, `js_challenge` or `managed_challenge`, and `configuration` with its `target` (`ip`, `ip_range`, `asn` or `country`) and `value`. `notes` is optional.
     *
     * @throws \Cloudflare\Exceptions\MissingArgumentException
     *
     * @return ResponseInterface Create an IP Access rule response
     */
    public function create(array $values): ResponseInterface
    {
        $this->requiredParams(['mode', 'configuration'], $values);

        return $this->getHttpClient()->post('/user/firewall/access_rules/rules', $values);
    }

    /**
     * Get a single IP Access rule defined at the user level.
     *
     * @link https://developers.cloudflare.com/api/resources/user/subresources/firewall/
     *
     * @param string $ruleId IP Access Rule Identifier.
     *
     * @return ResponseInterface IP Access rule details response
     */
    public function get(string $ruleId): ResponseInterface
    {
        return $this->getHttpClient()->get("/user/firewall/access_rules/rules/{$ruleId}");
    }

    /**
     * Apply changes to an IP Access rule, overwriting only the supplied properties.
     *
     * @link https://developers.cloudflare.com/api/resources/user/subresources/firewall/
     *
     * @param string $ruleId IP Access Rule Identifier.
     * @param array $values Values to set on the IP Access rule, e.g. `mode`, `notes`.
     *
     * @return ResponseInterface Edit an IP Access rule response
     */
    public function edit(string $ruleId, array $values): ResponseInterface
    {
        return $this->getHttpClient()->patch("/user/firewall/access_rules/rules/{$ruleId}", $values);
    }

    /**
     * Delete an IP Access rule defined at the user level.
     *
     * @link https://developers.cloudflare.com/api/resources/user/subresources/firewall/
     *
     * @param string $ruleId IP Access Rule Identifier.
     *
     * @return ResponseInterface Delete an IP Access rule response
     */
    public function delete(string $ruleId): ResponseInterface
    {
        return $this->getHttpClient()->delete("/user/firewall/access_rules/rules/{$ruleId}");
    }
}
