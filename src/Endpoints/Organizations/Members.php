<?php

namespace Cloudflare\Endpoints\Organizations;

use Cloudflare\Endpoints\AbstractEndpoint;
use Cloudflare\Contracts\ResponseInterface;

class Members extends AbstractEndpoint
{
    /**
     * List members of an organization.
     *
     * @param string $organizationId Organization identifier.
     * @param array $params Array containing the necessary params, e.g. status, user.email.
     *
     * @return ResponseInterface List Members response.
     */
    public function list(string $organizationId, array $params = []): ResponseInterface
    {
        return $this->getHttpClient()->get("/organizations/{$organizationId}/members", $params);
    }

    /**
     * Add a member to an organization.
     *
     * @param string $organizationId Organization identifier.
     * @param array $values Values, requires member.
     *
     * @return ResponseInterface Create Member response.
     */
    public function create(string $organizationId, array $values): ResponseInterface
    {
        $this->requiredParams(['member'], $values);

        return $this->getHttpClient()->post("/organizations/{$organizationId}/members", $values);
    }

    /**
     * Add multiple members to an organization in a single request.
     *
     * @param string $organizationId Organization identifier.
     * @param array $values Values, requires members.
     *
     * @return ResponseInterface Batch Create Members response.
     */
    public function batchCreate(string $organizationId, array $values): ResponseInterface
    {
        $this->requiredParams(['members'], $values);

        return $this->getHttpClient()->post("/organizations/{$organizationId}/members:batchCreate", $values);
    }

    /**
     * Get information about a specific member of an organization.
     *
     * @param string $organizationId Organization identifier.
     * @param string $memberId Member identifier.
     *
     * @return ResponseInterface Member Details response.
     */
    public function get(string $organizationId, string $memberId): ResponseInterface
    {
        return $this->getHttpClient()->get("/organizations/{$organizationId}/members/{$memberId}");
    }

    /**
     * Remove a member from an organization.
     *
     * @param string $organizationId Organization identifier.
     * @param string $memberId Member identifier.
     *
     * @return ResponseInterface Delete Member response.
     */
    public function delete(string $organizationId, string $memberId): ResponseInterface
    {
        return $this->getHttpClient()->delete("/organizations/{$organizationId}/members/{$memberId}", [
            'member_id' => $memberId,
        ]);
    }
}
