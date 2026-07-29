<?php

namespace Cloudflare\Endpoints\User\Tokens;

use Cloudflare\Endpoints\AbstractEndpoint;
use Cloudflare\Contracts\ResponseInterface;

class Value extends AbstractEndpoint
{
    /**
     * Roll the API token secret.
     *
     * @link https://developers.cloudflare.com/api/operations/user-api-tokens-roll-token
     *
     * @param string $tokenId Token identifier.
     *
     * @return ResponseInterface Roll Token response.
     */
    public function roll(string $tokenId): ResponseInterface
    {
        return $this->getHttpClient()->put("/user/tokens/{$tokenId}/value", []);
    }
}
