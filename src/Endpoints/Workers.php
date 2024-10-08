<?php

namespace Cloudflare\Endpoints;

use Cloudflare\Contracts\ResponseInterface;
use Cloudflare\Endpoints\Workers\Settings;
use Cloudflare\Endpoints\Workers\Cron;
use Cloudflare\Endpoints\Workers\Deployments;
use Cloudflare\Endpoints\Workers\Domains;
use Cloudflare\Endpoints\Workers\Environment;
use Cloudflare\Endpoints\Workers\Scripts;
use Cloudflare\Endpoints\Workers\Subdomain;
use Cloudflare\Endpoints\Workers\Logs;
use Cloudflare\Endpoints\Workers\Versions;
use Cloudflare\Endpoints\Workers\KV;
use Cloudflare\Endpoints\Workers\DurableObjects;
use Cloudflare\Endpoints\Workers\Routes;

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
     * @return ResponseInterface Query Request Analytics response
     */
    public function analytics(string $accountId, array $params = []): ResponseInterface
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
     * @return ResponseInterface Query Stored Data Analytics response
     */
    public function storedDataAnalytics(string $accountId, array $params = []): ResponseInterface
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
     * Worker Durable Objects
     *
     * @return DurableObjects
     */
    public function durableObjects(): DurableObjects
    {
        return new DurableObjects($this->getClient());
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
