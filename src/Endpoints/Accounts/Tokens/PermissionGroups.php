<?php

namespace Cloudflare\Endpoints\Accounts\Tokens;

use Cloudflare\Endpoints\AbstractEndpoint;
use Cloudflare\Contracts\ResponseInterface;

class PermissionGroups extends AbstractEndpoint
{
    /**
     * Find all available permission groups for Account Owned API Tokens.
     *
     * @link https://developers.cloudflare.com/api/resources/accounts/subresources/tokens/subresources/permission_groups/methods/list/
     *
     * @param string $accountId Account identifier.
     * @param array $params Array containing the necessary params, e.g. name, scope.
     *
     * @return ResponseInterface List Permission Groups response.
     */
    public function list(string $accountId, array $params = []): ResponseInterface
    {
        return $this->getHttpClient()->get("/accounts/{$accountId}/tokens/permission_groups", $params);
    }
}
