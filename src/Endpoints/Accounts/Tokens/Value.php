<?php

namespace Cloudflare\Endpoints\Accounts\Tokens;

use Cloudflare\Endpoints\AbstractEndpoint;
use Cloudflare\Contracts\ResponseInterface;

class Value extends AbstractEndpoint
{
    /**
     * Roll the Account Owned API token secret.
     *
     * @link https://developers.cloudflare.com/api/operations/account-api-tokens-roll-token
     *
     * @param string $accountId Account identifier.
     * @param string $tokenId Token identifier.
     *
     * @return ResponseInterface Roll Token response.
     */
    public function roll(string $accountId, string $tokenId): ResponseInterface
    {
        return $this->getHttpClient()->put("/accounts/{$accountId}/tokens/{$tokenId}/value", []);
    }
}
