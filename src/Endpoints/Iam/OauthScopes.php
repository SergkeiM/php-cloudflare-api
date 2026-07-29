<?php

namespace Cloudflare\Endpoints\Iam;

use Cloudflare\Endpoints\AbstractEndpoint;
use Cloudflare\Contracts\ResponseInterface;

class OauthScopes extends AbstractEndpoint
{
    /**
     * List all available OAuth scopes.
     *
     * @link https://developers.cloudflare.com/api/operations/oauth-scopes-list
     *
     * @return ResponseInterface List OAuth Scopes response.
     */
    public function list(): ResponseInterface
    {
        return $this->getHttpClient()->get('/oauth/scopes');
    }
}
