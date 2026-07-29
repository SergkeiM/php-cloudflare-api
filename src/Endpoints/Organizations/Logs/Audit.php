<?php

namespace Cloudflare\Endpoints\Organizations\Logs;

use Cloudflare\Endpoints\AbstractEndpoint;
use Cloudflare\Contracts\ResponseInterface;

class Audit extends AbstractEndpoint
{
    /**
     * Gets a list of audit logs for an organization.
     *
     * @link https://developers.cloudflare.com/api/operations/audit-logs-v2-get-organization-audit-logs
     *
     * @param string $organizationId Organization identifier.
     * @param array $params Array containing the necessary params, requires since and before.
     *
     * @return ResponseInterface List Audit Logs response.
     */
    public function list(string $organizationId, array $params = []): ResponseInterface
    {
        $this->requiredParams(['since', 'before'], $params);

        return $this->getHttpClient()->get("/organizations/{$organizationId}/logs/audit", $params);
    }

    /**
     * Returns the chronological change history for the resource identified by the given organization-scoped audit log entry.
     *
     * @link https://developers.cloudflare.com/api/operations/audit-logs-v2-get-organization-audit-log-history
     *
     * @param string $organizationId Organization identifier.
     * @param string $id Audit log entry identifier used to locate the resource.
     * @param array $params Array containing the necessary params, requires action_time, since and before.
     *
     * @return ResponseInterface Audit Log History response.
     */
    public function history(string $organizationId, string $id, array $params = []): ResponseInterface
    {
        $this->requiredParams(['action_time', 'since', 'before'], $params);

        return $this->getHttpClient()->get("/organizations/{$organizationId}/logs/audit/{$id}/history", $params);
    }
}
