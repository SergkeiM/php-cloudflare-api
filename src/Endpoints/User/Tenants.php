<?php

namespace Cloudflare\Endpoints\User;

use Cloudflare\Endpoints\AbstractEndpoint;
use Cloudflare\Contracts\ResponseInterface;

class Tenants extends AbstractEndpoint
{
    /**
     * Retrieves list of tenants the authenticated user has access to.
     *
     * @link https://developers.cloudflare.com/api/operations/User_listUserTenants
     *
     * @return ResponseInterface List Tenants response.
     */
    public function list(): ResponseInterface
    {
        return $this->getHttpClient()->get('/user/tenants');
    }
}
