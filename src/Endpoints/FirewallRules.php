<?php

namespace Cloudflare\Endpoints;

use Cloudflare\Contracts\ResponseInterface;

class FirewallRules extends AbstractEndpoint
{
    /**
     * List, search, sort, and filter a zone's firewall rules.
     *
     * @link https://developers.cloudflare.com/api/operations/firewall-rules-list-firewall-rules
     *
     * @param string $zoneId Zone Identifier.
     * @param array $params Query Parameters.
     *
     * @return ResponseInterface List firewall rules response
     */
    public function list(string $zoneId, array $params = []): ResponseInterface
    {
        return $this->getHttpClient()->get("/zones/{$zoneId}/firewall/rules", $params);
    }

    /**
     * Get a single firewall rule.
     *
     * @link https://developers.cloudflare.com/api/operations/firewall-rules-get-a-firewall-rule
     *
     * @param string $zoneId Zone Identifier.
     * @param string $ruleId Firewall Rule Identifier.
     *
     * @return ResponseInterface Get a firewall rule response
     */
    public function get(string $zoneId, string $ruleId): ResponseInterface
    {
        return $this->getHttpClient()->get("/zones/{$zoneId}/firewall/rules/{$ruleId}");
    }

    /**
     * Create one or more firewall rules.
     *
     * @link https://developers.cloudflare.com/api/operations/firewall-rules-create-firewall-rules
     *
     * @param string $zoneId Zone Identifier.
     * @param array $rules Array of firewall rule definitions, each referencing a filter by id (`filter: {id}`) or by inline expression (`filter: {expression}`), e.g. `[['action' => 'block', 'filter' => ['expression' => 'ip.src eq 127.0.0.1']]]`.
     *
     * @return ResponseInterface Create firewall rules response
     */
    public function create(string $zoneId, array $rules): ResponseInterface
    {
        return $this->getHttpClient()->post("/zones/{$zoneId}/firewall/rules", $rules);
    }

    /**
     * Update an existing firewall rule.
     *
     * @link https://developers.cloudflare.com/api/operations/firewall-rules-update-a-firewall-rule
     *
     * @param string $zoneId Zone Identifier.
     * @param string $ruleId Firewall Rule Identifier.
     * @param array $values Values to set on the firewall rule.
     *
     * @return ResponseInterface Update a firewall rule response
     */
    public function update(string $zoneId, string $ruleId, array $values): ResponseInterface
    {
        $this->requiredParams(['action', 'filter'], $values);

        return $this->getHttpClient()->put("/zones/{$zoneId}/firewall/rules/{$ruleId}", $values);
    }

    /**
     * Update the priority of an existing firewall rule.
     *
     * @link https://developers.cloudflare.com/api/operations/firewall-rules-update-priority-of-a-firewall-rule
     *
     * @param string $zoneId Zone Identifier.
     * @param string $ruleId Firewall Rule Identifier.
     * @param int $priority The priority of the rule, used to define the processing order. A lower number indicates a higher priority.
     *
     * @return ResponseInterface Update priority of a firewall rule response
     */
    public function updatePriority(string $zoneId, string $ruleId, int $priority): ResponseInterface
    {
        return $this->getHttpClient()->patch("/zones/{$zoneId}/firewall/rules/{$ruleId}", [
            'priority' => $priority,
        ]);
    }

    /**
     * Delete a firewall rule.
     *
     * @link https://developers.cloudflare.com/api/operations/firewall-rules-delete-a-firewall-rule
     *
     * @param string $zoneId Zone Identifier.
     * @param string $ruleId Firewall Rule Identifier.
     *
     * @return ResponseInterface Delete a firewall rule response
     */
    public function delete(string $zoneId, string $ruleId): ResponseInterface
    {
        return $this->getHttpClient()->delete("/zones/{$zoneId}/firewall/rules/{$ruleId}");
    }
}
