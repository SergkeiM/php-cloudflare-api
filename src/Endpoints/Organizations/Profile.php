<?php

namespace Cloudflare\Endpoints\Organizations;

use Cloudflare\Endpoints\AbstractEndpoint;
use Cloudflare\Contracts\ResponseInterface;

class Profile extends AbstractEndpoint
{
    /**
     * Get an organizations profile if it exists.
     *
     * @link https://developers.cloudflare.com/api/operations/Organizations_getProfile
     *
     * @param string $organizationId Organization identifier.
     *
     * @return ResponseInterface Organization Profile response.
     */
    public function get(string $organizationId): ResponseInterface
    {
        return $this->getHttpClient()->get("/organizations/{$organizationId}/profile");
    }

    /**
     * Modify organization profile.
     *
     * @link https://developers.cloudflare.com/api/operations/Organizations_modifyProfile
     *
     * @param string $organizationId Organization identifier.
     * @param array $values Profile values, requires business_name, business_email, business_phone, business_address and external_metadata.
     *
     * @return ResponseInterface Update Organization Profile response.
     */
    public function update(string $organizationId, array $values): ResponseInterface
    {
        $this->requiredParams([
            'business_name',
            'business_email',
            'business_phone',
            'business_address',
            'external_metadata',
        ], $values);

        return $this->getHttpClient()->put("/organizations/{$organizationId}/profile", $values);
    }
}
