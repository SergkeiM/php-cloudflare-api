<?php

namespace Cloudflare\Endpoints;

use Cloudflare\Endpoints\Iam\PermissionGroups;
use Cloudflare\Endpoints\Iam\ResourceGroups;
use Cloudflare\Endpoints\Iam\Sso;
use Cloudflare\Endpoints\Iam\OauthClients;
use Cloudflare\Endpoints\Iam\OauthScopes;
use Cloudflare\Endpoints\Iam\UserGroups;

/**
 * Identity and Access Management.
 */
class Iam extends AbstractEndpoint
{
    /**
     * Account Permission Groups
     *
     * @return \Cloudflare\Endpoints\Iam\PermissionGroups
     */
    public function permissionGroups(): PermissionGroups
    {
        return new PermissionGroups($this->getClient());
    }

    /**
     * Account Resource Groups
     *
     * @return \Cloudflare\Endpoints\Iam\ResourceGroups
     */
    public function resourceGroups(): ResourceGroups
    {
        return new ResourceGroups($this->getClient());
    }

    /**
     * SSO Connectors
     *
     * @return \Cloudflare\Endpoints\Iam\Sso
     */
    public function sso(): Sso
    {
        return new Sso($this->getClient());
    }

    /**
     * OAuth Clients
     *
     * @return \Cloudflare\Endpoints\Iam\OauthClients
     */
    public function oauthClients(): OauthClients
    {
        return new OauthClients($this->getClient());
    }

    /**
     * OAuth Scopes
     *
     * @return \Cloudflare\Endpoints\Iam\OauthScopes
     */
    public function oauthScopes(): OauthScopes
    {
        return new OauthScopes($this->getClient());
    }

    /**
     * Account User Groups
     *
     * @return \Cloudflare\Endpoints\Iam\UserGroups
     */
    public function userGroups(): UserGroups
    {
        return new UserGroups($this->getClient());
    }
}
