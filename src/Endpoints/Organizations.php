<?php

namespace Cloudflare\Endpoints;

use Cloudflare\Contracts\ResponseInterface;
use Cloudflare\Endpoints\Organizations\Profile;
use Cloudflare\Endpoints\Organizations\Logs;
use Cloudflare\Endpoints\Organizations\Billing;
use Cloudflare\Endpoints\Organizations\Members;

/**
 * @link https://developers.cloudflare.com/fundamentals/organizations/
 */
class Organizations extends AbstractEndpoint
{
    /**
     * Retrieve a list of organizations a particular user has access to.
     *
     * @link https://developers.cloudflare.com/api/operations/Organization_listOrganizations
     *
     * @param array $params Array containing the necessary params.
     *
     * @return ResponseInterface List Organizations response.
     */
    public function list(array $params = []): ResponseInterface
    {
        return $this->getHttpClient()->get('/organizations', $params);
    }

    /**
     * Create a new organization for a user.
     *
     * @link https://developers.cloudflare.com/api/operations/Organizations_createUserOrganization
     *
     * @param array $values Organization values, requires name.
     *
     * @return ResponseInterface Create Organization response.
     */
    public function create(array $values): ResponseInterface
    {
        $this->requiredParams(['name'], $values);

        return $this->getHttpClient()->post('/organizations', $values);
    }

    /**
     * Retrieve the details of a certain organization.
     *
     * @link https://developers.cloudflare.com/api/operations/Organizations_retrieve
     *
     * @param string $organizationId Organization identifier.
     *
     * @return ResponseInterface Organization Details response.
     */
    public function get(string $organizationId): ResponseInterface
    {
        return $this->getHttpClient()->get("/organizations/{$organizationId}");
    }

    /**
     * Modify organization.
     *
     * @link https://developers.cloudflare.com/api/operations/Organizations_modify
     *
     * @param string $organizationId Organization identifier.
     * @param array $values Organization values, e.g. name.
     *
     * @return ResponseInterface Update Organization response.
     */
    public function update(string $organizationId, array $values = []): ResponseInterface
    {
        return $this->getHttpClient()->put("/organizations/{$organizationId}", $values);
    }

    /**
     * Delete an organization. The organization MUST be empty before deleting.
     *
     * @link https://developers.cloudflare.com/api/operations/Organizations_delete
     *
     * @param string $organizationId Organization identifier.
     *
     * @return ResponseInterface Delete Organization response.
     */
    public function delete(string $organizationId): ResponseInterface
    {
        return $this->getHttpClient()->delete("/organizations/{$organizationId}");
    }

    /**
     * Organization Profile
     *
     * @return \Cloudflare\Endpoints\Organizations\Profile
     */
    public function profile(): Profile
    {
        return new Profile($this->getClient());
    }

    /**
     * Organization Logs
     *
     * @return \Cloudflare\Endpoints\Organizations\Logs
     */
    public function logs(): Logs
    {
        return new Logs($this->getClient());
    }

    /**
     * Organization Billing
     *
     * @return \Cloudflare\Endpoints\Organizations\Billing
     */
    public function billing(): Billing
    {
        return new Billing($this->getClient());
    }

    /**
     * Organization Members
     *
     * @return \Cloudflare\Endpoints\Organizations\Members
     */
    public function members(): Members
    {
        return new Members($this->getClient());
    }
}
