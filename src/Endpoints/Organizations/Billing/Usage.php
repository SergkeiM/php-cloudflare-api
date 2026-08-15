<?php

namespace Cloudflare\Endpoints\Organizations\Billing;

use Cloudflare\Endpoints\AbstractEndpoint;
use Cloudflare\Contracts\ResponseInterface;

class Usage extends AbstractEndpoint
{
    /**
     * Returns cost and usage data for all accounts within an organization, aligned with the FinOps FOCUS v1.3 Cost and Usage dataset specification.
     *
     * @link https://developers.cloudflare.com/api/resources/organizations/subresources/billing/subresources/usage/methods/get/
     *
     * @param string $organizationId Organization identifier.
     * @param array $params Array containing the necessary params, e.g. from, to.
     *
     * @return ResponseInterface Billing Usage response.
     */
    public function get(string $organizationId, array $params = []): ResponseInterface
    {
        return $this->getHttpClient()->get("/organizations/{$organizationId}/billable/usage", $params);
    }
}
