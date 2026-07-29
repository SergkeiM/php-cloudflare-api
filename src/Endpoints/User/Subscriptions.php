<?php

namespace Cloudflare\Endpoints\User;

use Cloudflare\Endpoints\AbstractEndpoint;
use Cloudflare\Contracts\ResponseInterface;

class Subscriptions extends AbstractEndpoint
{
    /**
     * Lists all of a user's subscriptions.
     *
     * @link https://developers.cloudflare.com/api/operations/user-subscription-get-user-subscriptions
     *
     * @return ResponseInterface List Subscriptions response.
     */
    public function list(): ResponseInterface
    {
        return $this->getHttpClient()->get('/user/subscriptions');
    }

    /**
     * Creates a user subscription.
     *
     * @link https://developers.cloudflare.com/api/operations/user-subscription-create-user-subscription
     *
     * @param array $values Subscription values, e.g. frequency, rate_plan.
     *
     * @return ResponseInterface Create Subscription response.
     */
    public function create(array $values = []): ResponseInterface
    {
        return $this->getHttpClient()->post('/user/subscriptions', $values);
    }

    /**
     * Updates a user's subscription.
     *
     * @link https://developers.cloudflare.com/api/operations/user-subscription-update-user-subscription
     *
     * @param string $subscriptionId Subscription identifier tag.
     * @param array $values Subscription values, e.g. frequency, rate_plan.
     *
     * @return ResponseInterface Update Subscription response.
     */
    public function update(string $subscriptionId, array $values = []): ResponseInterface
    {
        return $this->getHttpClient()->put("/user/subscriptions/{$subscriptionId}", $values);
    }

    /**
     * Deletes a user's subscription.
     *
     * @link https://developers.cloudflare.com/api/operations/user-subscription-delete-user-subscription
     *
     * @param string $subscriptionId Subscription identifier tag.
     *
     * @return ResponseInterface Delete Subscription response.
     */
    public function delete(string $subscriptionId): ResponseInterface
    {
        return $this->getHttpClient()->delete("/user/subscriptions/{$subscriptionId}");
    }
}
