<?php

namespace Cloudflare\Endpoints\Workers;

use Cloudflare\Endpoints\AbstractEndpoint;
use Cloudflare\Contracts\ResponseInterface;

class Settings extends AbstractEndpoint
{
    /**
      * Fetches Worker account settings for an account.
      *
      * @link https://developers.cloudflare.com/api/operations/worker-account-settings-fetch-worker-account-settings
      *
      * @param string $accountId Account identifier.
      *
      * @return ResponseInterface Fetch Worker Account Settings response
      */
    public function get(string $accountId): ResponseInterface
    {
        return $this->getHttpClient()->get("/accounts/{$accountId}/workers/account-settings");
    }

    /**
     * Create Worker Account Settings
     *
     * @link https://developers.cloudflare.com/api/operations/worker-account-settings-create-worker-account-settings
     *
     * @param string $accountId Account identifier.
     * @param string $usageModel Default usage model.
     * @param boolean $greenCompute Green compute.
     *
     * @return ResponseInterface Create Worker Account Settings response
     */
    public function create(string $accountId, string $usageModel, bool $greenCompute): ResponseInterface
    {
        return $this->getHttpClient()->put("/accounts/{$accountId}/workers/account-settings", [
            'default_usage_model' => $usageModel,
            'green_compute' => $greenCompute
        ]);
    }
}
