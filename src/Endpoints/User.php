<?php

namespace Cloudflare\Endpoints;

use Cloudflare\Contracts\ResponseInterface;
use Cloudflare\Endpoints\User\AccessRules;
use Cloudflare\Endpoints\User\AuditLogs;
use Cloudflare\Endpoints\User\CommunicationPreferences;
use Cloudflare\Endpoints\User\Invites;
use Cloudflare\Endpoints\User\LoadBalancers;
use Cloudflare\Endpoints\User\Subscriptions;
use Cloudflare\Endpoints\User\Tenants;
use Cloudflare\Endpoints\User\Tokens;

/**
 * @link https://developers.cloudflare.com/api/resources/user/methods/get/
 */
class User extends AbstractEndpoint
{
    /**
     * Retrieves detailed information about the currently authenticated user, including email, name, and account memberships.
     *
     * @link https://developers.cloudflare.com/api/resources/user/methods/get/
     *
     * @return ResponseInterface User Details response.
     */
    public function get(): ResponseInterface
    {
        return $this->getHttpClient()->get('/user');
    }

    /**
     * Edit part of your user details.
     *
     * @link https://developers.cloudflare.com/api/resources/user/methods/edit/
     *
     * @param array $values User values, e.g. first_name, last_name, telephone, country, zipcode.
     *
     * @return ResponseInterface Update User response.
     */
    public function edit(array $values = []): ResponseInterface
    {
        return $this->getHttpClient()->patch('/user', $values);
    }

    /**
     * User Audit Logs
     *
     * @return \Cloudflare\Endpoints\User\AuditLogs
     */
    public function auditLogs(): AuditLogs
    {
        return new AuditLogs($this->getClient());
    }

    /**
     * User Invites
     *
     * @return \Cloudflare\Endpoints\User\Invites
     */
    public function invites(): Invites
    {
        return new Invites($this->getClient());
    }

    /**
     * User Subscriptions
     *
     * @return \Cloudflare\Endpoints\User\Subscriptions
     */
    public function subscriptions(): Subscriptions
    {
        return new Subscriptions($this->getClient());
    }

    /**
     * User Tenants
     *
     * @return \Cloudflare\Endpoints\User\Tenants
     */
    public function tenants(): Tenants
    {
        return new Tenants($this->getClient());
    }

    /**
     * User API Tokens
     *
     * @return \Cloudflare\Endpoints\User\Tokens
     */
    public function tokens(): Tokens
    {
        return new Tokens($this->getClient());
    }

    /**
     * User Communication Preferences
     *
     * @return \Cloudflare\Endpoints\User\CommunicationPreferences
     */
    public function communicationPreferences(): CommunicationPreferences
    {
        return new CommunicationPreferences($this->getClient());
    }

    /**
     * User IP Access Rules
     *
     * @return \Cloudflare\Endpoints\User\AccessRules
     */
    public function accessRules(): AccessRules
    {
        return new AccessRules($this->getClient());
    }

    /**
     * User Load Balancers
     *
     * @return \Cloudflare\Endpoints\User\LoadBalancers
     */
    public function loadBalancers(): LoadBalancers
    {
        return new LoadBalancers($this->getClient());
    }
}
