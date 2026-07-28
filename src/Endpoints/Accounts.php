<?php

namespace Cloudflare\Endpoints;

use Cloudflare\Contracts\ResponseInterface;
use Cloudflare\Endpoints\Accounts\Roles;
use Cloudflare\Endpoints\Accounts\Members;
use Cloudflare\Endpoints\Accounts\AuditLogs;
use Cloudflare\Endpoints\Accounts\Rulesets;
use Cloudflare\Endpoints\Accounts\LoadBalancers;
use Cloudflare\Endpoints\Accounts\LoadBalancerMonitors;
use Cloudflare\Endpoints\Accounts\LoadBalancerPools;
use Cloudflare\Endpoints\Accounts\LoadBalancerRegions;
use Cloudflare\Endpoints\Accounts\LoadBalancerMonitorGroups;
use Cloudflare\Endpoints\Accounts\R2Buckets;
use Cloudflare\Endpoints\Accounts\R2Cors;
use Cloudflare\Endpoints\Accounts\R2Lifecycle;
use Cloudflare\Endpoints\Accounts\R2Lock;
use Cloudflare\Endpoints\Accounts\R2CustomDomains;
use Cloudflare\Endpoints\Accounts\R2ManagedDomain;
use Cloudflare\Endpoints\Accounts\R2Sippy;
use Cloudflare\Endpoints\Accounts\R2EventNotifications;
use Cloudflare\Endpoints\Accounts\R2Metrics;

/**
 * @link https://developers.cloudflare.com/api/operations/accounts-list-accounts
 */
class Accounts extends AbstractEndpoint
{
    /**
     * List all accounts you have ownership or verified access to.
     *
     * @link https://developers.cloudflare.com/api/operations/accounts-list-accounts
     *
     * @param array $params Array containing the necessary params.
     *
     * @return \Cloudflare\Contracts\ResponseInterface List Accounts response.
     */
    public function list(array $params = []): ResponseInterface
    {
        return $this->getHttpClient()->get('/accounts', $params);
    }

    /**
     * Create an account (only available for tenant admins at this time)
     *
     * @link https://developers.cloudflare.com/api/operations/account-creation
     *
     * @param string $name Account name
     * @param string $type The type of account being created. For self-serve customers, use standard. for enterprise customers, use enterprise.
     * @param string $unit Tenant unit ID. Information related to the tenant unit, and optionally, an id of the unit to create the account on. [see](https://developers.cloudflare.com/tenant/how-to/manage-accounts/)
     *
     * @return \Cloudflare\Contracts\ResponseInterface
     */
    public function create(string $name, string $type, ?string $unit = null): ResponseInterface
    {
        $values = [
            'name' => $name,
            'type' => $type
        ];

        if (!is_null($unit)) {
            $values['unit'] = [
                'id' => $unit
            ];
        }

        return $this->getHttpClient()->post("/accounts", $values);
    }

    /**
     * Get information about a specific account that you are a member of.
     *
     * @link https://developers.cloudflare.com/api/operations/accounts-account-details
     *
     * @param string $accountId Account identifier.
     *
     * @return \Cloudflare\Contracts\ResponseInterface Account Details response.
     */
    public function details(string $accountId): ResponseInterface
    {
        return $this->getHttpClient()->get("/accounts/{$accountId}");
    }

    /**
     * Get information about a specific account that you are a member of.
     *
     * @link https://developers.cloudflare.com/api/operations/accounts-update-account
     *
     * @param string $accountId Account identifier.
     * @param string $name Account name.
     * @param array $settings Account settings.
     *
     * @return \Cloudflare\Contracts\ResponseInterface Update Account response.
     */
    public function update(string $accountId, string $name, array $settings = []): ResponseInterface
    {

        $values = [
            'name' => $name,
        ];

        if (!empty($settings)) {
            $values['settings'] = $settings;
        }

        return $this->getHttpClient()->put("/accounts/{$accountId}", $values);
    }

    /**
     * Delete a specific account (only available for tenant admins at this time). This is a permanent operation that will delete any zones or other resources under the account
     *
     * @link https://developers.cloudflare.com/api/operations/account-deletion
     *
     * @param string $accountIdAccount identifier.
     *
     * @return \Cloudflare\Contracts\ResponseInterface
     */
    public function delete(string $accountId): ResponseInterface
    {
        return $this->getHttpClient()->delete("/accounts/{$accountId}");
    }

    /**
     * Account Roles
     *
     * @return \Cloudflare\Endpoints\Accounts\Roles
     */
    public function roles(): Roles
    {
        return new Roles($this->getClient());
    }

    /**
     * Account Members
     *
     * @return \Cloudflare\Endpoints\Accounts\Members
     */
    public function members(): Members
    {
        return new Members($this->getClient());
    }

    /**
     * Account audit logs
     *
     * @return \Cloudflare\Endpoints\Accounts\AuditLogs
     */
    public function auditLogs(): AuditLogs
    {
        return new AuditLogs($this->getClient());
    }

    /**
     * Account Rulesets
     *
     * @return \Cloudflare\Endpoints\Accounts\Rulesets
     */
    public function rulesets(): Rulesets
    {
        return new Rulesets($this->getClient());
    }

    /**
     * Account Load Balancers
     *
     * @return \Cloudflare\Endpoints\Accounts\LoadBalancers
     */
    public function loadBalancers(): LoadBalancers
    {
        return new LoadBalancers($this->getClient());
    }

    /**
     * Account Load Balancer Monitors
     *
     * @return \Cloudflare\Endpoints\Accounts\LoadBalancerMonitors
     */
    public function loadBalancerMonitors(): LoadBalancerMonitors
    {
        return new LoadBalancerMonitors($this->getClient());
    }

    /**
     * Account Load Balancer Pools
     *
     * @return \Cloudflare\Endpoints\Accounts\LoadBalancerPools
     */
    public function loadBalancerPools(): LoadBalancerPools
    {
        return new LoadBalancerPools($this->getClient());
    }

    /**
     * Account Load Balancer Regions
     *
     * @return \Cloudflare\Endpoints\Accounts\LoadBalancerRegions
     */
    public function loadBalancerRegions(): LoadBalancerRegions
    {
        return new LoadBalancerRegions($this->getClient());
    }

    /**
     * Account Load Balancer Monitor Groups
     *
     * @return \Cloudflare\Endpoints\Accounts\LoadBalancerMonitorGroups
     */
    public function loadBalancerMonitorGroups(): LoadBalancerMonitorGroups
    {
        return new LoadBalancerMonitorGroups($this->getClient());
    }

    /**
     * Account R2 Buckets
     *
     * @return \Cloudflare\Endpoints\Accounts\R2Buckets
     */
    public function r2Buckets(): R2Buckets
    {
        return new R2Buckets($this->getClient());
    }

    /**
     * Account R2 Bucket CORS
     *
     * @return \Cloudflare\Endpoints\Accounts\R2Cors
     */
    public function r2Cors(): R2Cors
    {
        return new R2Cors($this->getClient());
    }

    /**
     * Account R2 Bucket Lifecycle
     *
     * @return \Cloudflare\Endpoints\Accounts\R2Lifecycle
     */
    public function r2Lifecycle(): R2Lifecycle
    {
        return new R2Lifecycle($this->getClient());
    }

    /**
     * Account R2 Bucket Object Lock
     *
     * @return \Cloudflare\Endpoints\Accounts\R2Lock
     */
    public function r2Lock(): R2Lock
    {
        return new R2Lock($this->getClient());
    }

    /**
     * Account R2 Bucket Custom Domains
     *
     * @return \Cloudflare\Endpoints\Accounts\R2CustomDomains
     */
    public function r2CustomDomains(): R2CustomDomains
    {
        return new R2CustomDomains($this->getClient());
    }

    /**
     * Account R2 Bucket Managed Domain
     *
     * @return \Cloudflare\Endpoints\Accounts\R2ManagedDomain
     */
    public function r2ManagedDomain(): R2ManagedDomain
    {
        return new R2ManagedDomain($this->getClient());
    }

    /**
     * Account R2 Bucket Sippy
     *
     * @return \Cloudflare\Endpoints\Accounts\R2Sippy
     */
    public function r2Sippy(): R2Sippy
    {
        return new R2Sippy($this->getClient());
    }

    /**
     * Account R2 Bucket Event Notifications
     *
     * @return \Cloudflare\Endpoints\Accounts\R2EventNotifications
     */
    public function r2EventNotifications(): R2EventNotifications
    {
        return new R2EventNotifications($this->getClient());
    }

    /**
     * Account R2 Metrics
     *
     * @return \Cloudflare\Endpoints\Accounts\R2Metrics
     */
    public function r2Metrics(): R2Metrics
    {
        return new R2Metrics($this->getClient());
    }
}
