<?php

namespace Cloudflare\Endpoints;

use Cloudflare\Contracts\ResponseInterface;

/**
 * @link https://developers.cloudflare.com/api/operations/cloudflare-i-ps-cloudflare-ip-details
 */
class IP extends AbstractEndpoint
{
    /**
     * Get IPs used on the Cloudflare/JD Cloud network
     * For Cloudflare IPs: https://www.cloudflare.com/ips
     * For JD Cloud IPs: https://developers.cloudflare.com/china-network/reference/infrastructure/ .
     * @link https://developers.cloudflare.com/api/operations/cloudflare-i-ps-cloudflare-ip-details
     *
     * @return ResponseInterface Cloudflare/JD Cloud IP Details response
     */
    public function get(): ResponseInterface
    {
        return $this->getHttpClient()->get('/ips');
    }
}
