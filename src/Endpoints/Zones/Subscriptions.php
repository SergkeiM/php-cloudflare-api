<?php

namespace Cloudflare\Endpoints\Zones;

use Cloudflare\Endpoints\AbstractEndpoint;
use Cloudflare\Contracts\ResponseInterface;

class Subscriptions extends AbstractEndpoint
{
    /**
     * Lists zone subscription details.
     *
     * @link https://developers.cloudflare.com/api/resources/zones/subresources/subscriptions/methods/get/
     *
     * @param string $zoneId Zone Identifier.
     *
     * @return ResponseInterface Zone Subscription Details response.
     */
    public function get(string $zoneId): ResponseInterface
    {
        return $this->getHttpClient()->get("/zones/{$zoneId}/subscription");
    }

    /**
     * Create a zone subscription, either plan or add-ons.
     *
     * ```php
     * $client->zones()->subscriptions()->create('ZONE_ID', [
     *     'frequency' => 'monthly',
     *     'rate_plan' => ['id' => 'PARTNERS_PRO'],
     * ]);
     * ```
     *
     * @link https://developers.cloudflare.com/api/resources/zones/subresources/subscriptions/methods/create/
     *
     * @param string $zoneId Zone Identifier.
     * @param array $values Subscription values, e.g. `frequency`, `rate_plan`.
     *
     * @return ResponseInterface Create Zone Subscription response.
     */
    public function create(string $zoneId, array $values = []): ResponseInterface
    {
        return $this->getHttpClient()->post("/zones/{$zoneId}/subscription", $values);
    }

    /**
     * Updates zone subscriptions, either plan or add-ons.
     *
     * @link https://developers.cloudflare.com/api/resources/zones/subresources/subscriptions/methods/update/
     *
     * @param string $zoneId Zone Identifier.
     * @param array $values Subscription values, e.g. `frequency`, `rate_plan`.
     *
     * @return ResponseInterface Update Zone Subscription response.
     */
    public function update(string $zoneId, array $values = []): ResponseInterface
    {
        return $this->getHttpClient()->put("/zones/{$zoneId}/subscription", $values);
    }

    /**
     * Deletes a zone's subscription.
     *
     * @param string $zoneId Zone Identifier.
     *
     * @return ResponseInterface Delete Zone Subscription response.
     */
    public function delete(string $zoneId): ResponseInterface
    {
        return $this->getHttpClient()->delete("/zones/{$zoneId}/subscription");
    }
}
