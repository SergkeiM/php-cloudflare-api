<?php

namespace Cloudflare\Endpoints\Accounts;

use Cloudflare\Endpoints\AbstractEndpoint;
use Cloudflare\Contracts\ResponseInterface;

class Subscriptions extends AbstractEndpoint
{
    /**
     * Lists all of an account's subscriptions.
     *
     * @link https://developers.cloudflare.com/api/resources/accounts/subresources/subscriptions/methods/get/
     *
     * @param string $accountId Account identifier.
     *
     * @return ResponseInterface List Subscriptions response.
     */
    public function list(string $accountId): ResponseInterface
    {
        return $this->getHttpClient()->get("/accounts/{$accountId}/subscriptions");
    }

    /**
     * Creates an account subscription.
     *
     * @link https://developers.cloudflare.com/api/resources/accounts/subresources/subscriptions/methods/create/
     *
     * @param string $accountId Account identifier.
     * @param array $values Subscription values, e.g. frequency, rate_plan.
     *
     * @return ResponseInterface Create Subscription response.
     */
    public function create(string $accountId, array $values = []): ResponseInterface
    {
        return $this->getHttpClient()->post("/accounts/{$accountId}/subscriptions", $values);
    }

    /**
     * Updates an account subscription.
     *
     * @link https://developers.cloudflare.com/api/resources/accounts/subresources/subscriptions/methods/update/
     *
     * @param string $accountId Account identifier.
     * @param string $subscriptionId Subscription identifier tag.
     * @param array $values Subscription values, e.g. frequency, rate_plan.
     *
     * @return ResponseInterface Update Subscription response.
     */
    public function update(string $accountId, string $subscriptionId, array $values = []): ResponseInterface
    {
        return $this->getHttpClient()->put("/accounts/{$accountId}/subscriptions/{$subscriptionId}", $values);
    }

    /**
     * Smartly applies the incoming subscription into the lifecycle of the subscription.
     *
     * Unlike `update()`, which overwrites, this asks Cloudflare to work out how
     * the supplied subscription should be folded into the existing one.
     *
     * @param string $accountId Account identifier.
     * @param string $subscriptionId Subscription identifier tag.
     * @param array $values Subscription values, e.g. frequency, rate_plan.
     *
     * @return ResponseInterface Append Subscription Action response.
     */
    public function append(string $accountId, string $subscriptionId, array $values = []): ResponseInterface
    {
        return $this->getHttpClient()->post("/accounts/{$accountId}/subscriptions/{$subscriptionId}/action/append", $values);
    }

    /**
     * Deletes an account's subscription.
     *
     * @link https://developers.cloudflare.com/api/resources/accounts/subresources/subscriptions/methods/delete/
     *
     * @param string $accountId Account identifier.
     * @param string $subscriptionId Subscription identifier tag.
     *
     * @return ResponseInterface Delete Subscription response.
     */
    public function delete(string $accountId, string $subscriptionId): ResponseInterface
    {
        return $this->getHttpClient()->delete("/accounts/{$accountId}/subscriptions/{$subscriptionId}");
    }
}
