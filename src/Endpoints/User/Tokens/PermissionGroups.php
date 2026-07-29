<?php

namespace Cloudflare\Endpoints\User\Tokens;

use Cloudflare\Endpoints\AbstractEndpoint;
use Cloudflare\Contracts\ResponseInterface;

class PermissionGroups extends AbstractEndpoint
{
    /**
     * Find all available permission groups for API Tokens.
     *
     * @link https://developers.cloudflare.com/api/operations/permission-groups-list-permission-groups
     *
     * @param array $params Array containing the necessary params, e.g. name, scope.
     *
     * @return ResponseInterface List Permission Groups response.
     */
    public function list(array $params = []): ResponseInterface
    {
        return $this->getHttpClient()->get('/user/tokens/permission_groups', $params);
    }
}
