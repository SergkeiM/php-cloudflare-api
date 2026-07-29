<?php

namespace Cloudflare\Endpoints;

use Cloudflare\Contracts\ResponseInterface;

class Memberships extends AbstractEndpoint
{
    /**
     * List memberships of accounts the user can access.
     *
     * @link https://developers.cloudflare.com/api/operations/user's-account-memberships-list-memberships
     *
     * @param array $params Array containing the necessary params.
     *
     * @return ResponseInterface List Memberships response.
     */
    public function list(array $params = []): ResponseInterface
    {
        return $this->getHttpClient()->get('/memberships', $params);
    }

    /**
     * Get a specific membership.
     *
     * @link https://developers.cloudflare.com/api/operations/user's-account-memberships-membership-details
     *
     * @param string $membershipId Membership identifier tag.
     *
     * @return ResponseInterface Membership Details response.
     */
    public function get(string $membershipId): ResponseInterface
    {
        return $this->getHttpClient()->get("/memberships/{$membershipId}");
    }

    /**
     * Accept or reject this account invitation.
     *
     * @link https://developers.cloudflare.com/api/operations/user's-account-memberships-update-membership
     *
     * @param string $membershipId Membership identifier tag.
     * @param string $status Status of this membership, e.g. accepted, rejected.
     *
     * @return ResponseInterface Update Membership response.
     */
    public function update(string $membershipId, string $status): ResponseInterface
    {
        return $this->getHttpClient()->put("/memberships/{$membershipId}", [
            'status' => $status,
        ]);
    }

    /**
     * Remove the associated member from an account.
     *
     * @link https://developers.cloudflare.com/api/operations/user's-account-memberships-delete-membership
     *
     * @param string $membershipId Membership identifier tag.
     *
     * @return ResponseInterface Delete Membership response.
     */
    public function delete(string $membershipId): ResponseInterface
    {
        return $this->getHttpClient()->delete("/memberships/{$membershipId}");
    }
}
