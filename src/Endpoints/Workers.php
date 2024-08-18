<?php

namespace SergkeiM\CloudFlare\Endpoints;

use SergkeiM\CloudFlare\Endpoints\AbstractEndpoint;
use SergkeiM\CloudFlare\Contracts\CloudFlareResponse;
use SergkeiM\CloudFlare\Endpoints\Workers\Settings;
use SergkeiM\CloudFlare\Endpoints\Workers\Cron;
use SergkeiM\CloudFlare\Endpoints\Workers\Deployments;
use SergkeiM\CloudFlare\Endpoints\Workers\Domains;
use SergkeiM\CloudFlare\Endpoints\Workers\Environment;
use SergkeiM\CloudFlare\Endpoints\Workers\Scripts;
use SergkeiM\CloudFlare\Endpoints\Workers\Subdomain;
use SergkeiM\CloudFlare\Endpoints\Workers\Logs;
use SergkeiM\CloudFlare\Endpoints\Workers\Versions;
use SergkeiM\CloudFlare\Endpoints\Workers\KV;
use SergkeiM\CloudFlare\Endpoints\Workers\Routes;

class Workers extends AbstractEndpoint
{
    /**
     * Retrieves Workers KV request metrics for the given account.
     *
     * @link https://developers.cloudflare.com/api/operations/workers-kv-request-analytics-query-request-analytics
     *
     * @param string $accountId Account identifier.
     * @param array $params Array containing the necessary params.
     *
     * @return CloudFlareResponse Query Request Analytics response
     */
    public function analytics(string $accountId, array $params = []): CloudFlareResponse
    {
        return $this->getHttpClient()->get("/accounts/{$accountId}/storage/analytics", $params);
    }

    /**
     * Retrieves Workers KV stored data metrics for the given account.
     *
     * @link https://developers.cloudflare.com/api/operations/workers-kv-stored-data-analytics-query-stored-data-analytics
     *
     * @param string $accountId Account identifier.
     * @param array $params Array containing the necessary params.
     *
     * @return CloudFlareResponse Query Stored Data Analytics response
     */
    public function storedDataAnalytics(string $accountId, array $params = []): CloudFlareResponse
    {
        return $this->getHttpClient()->get("/accounts/{$accountId}/storage/analytics/stored", $params);
    }

    /**
     * Worker Account Settings
     *
     * @return Settings
     */
    public function settings(): Settings
    {
        return new Settings($this->getClient());
    }

    /**
     * Worker Account Cron
     *
     * @return Cron
     */
    public function cron(): Cron
    {
        return new Cron($this->getClient());
    }

    /**
     * Worker Account deployments
     *
     * @return Deployments
     */
    public function deployments(): Deployments
    {
        return new Deployments($this->getClient());
    }

    /**
     * Worker Account domains
     *
     * @return Domains
     */
    public function domains(): Domains
    {
        return new Domains($this->getClient());
    }

    /**
     * Worker Account Environment
     *
     * @return Environment
     */
    public function environment(): Environment
    {
        return new Environment($this->getClient());
    }

    /**
     * Worker Scripts
     *
     * @return Scripts
     */
    public function scripts(): Scripts
    {
        return new Scripts($this->getClient());
    }

    /**
     * Worker Subdomain
     *
     * @return Subdomain
     */
    public function subdomain(): Subdomain
    {
        return new Subdomain($this->getClient());
    }

    /**
     * Worker Logs
     *
     * @return Logs
     */
    public function logs(): Logs
    {
        return new Logs($this->getClient());
    }

    /**
     * Worker Versions
     *
     * @return Versions
     */
    public function versions(): Versions
    {
        return new Versions($this->getClient());
    }

    /**
     * Worker KV Storage
     *
     * @return KV
     */
    public function kv(): KV
    {
        return new KV($this->getClient());
    }

    /**
     * Worker Zone Routes
     *
     * @return Routes
     */
    public function routes(): Routes
    {
        return new Routes($this->getClient());
    }
}
