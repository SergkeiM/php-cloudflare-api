<?php

namespace Cloudflare\Endpoints;

use Cloudflare\Contracts\ResponseInterface;
use Cloudflare\Endpoints\User\AuditLogs;
use Cloudflare\Endpoints\User\Invites;
use Cloudflare\Endpoints\User\Subscriptions;
use Cloudflare\Endpoints\User\Tenants;
use Cloudflare\Endpoints\User\Tokens;

/**
 * @link https://developers.cloudflare.com/api/operations/user-user-details
 */
class User extends AbstractEndpoint
{
    /**
     * Retrieves detailed information about the currently authenticated user, including email, name, and account memberships.
     *
     * @link https://developers.cloudflare.com/api/operations/user-user-details
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
     * @link https://developers.cloudflare.com/api/operations/user-edit-user
     *
     * @param array $values User values, e.g. first_name, last_name, telephone, country, zipcode.
     *
     * @return ResponseInterface Update User response.
     */
    public function update(array $values = []): ResponseInterface
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
}
