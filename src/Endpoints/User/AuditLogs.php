<?php

namespace Cloudflare\Endpoints\User;

use Cloudflare\Endpoints\AbstractEndpoint;
use Cloudflare\Contracts\ResponseInterface;

class AuditLogs extends AbstractEndpoint
{
    /**
     * Gets a list of audit logs for a user account. Can be filtered by who made the change, on which zone, and the timeframe of the change.
     *
     * @link https://developers.cloudflare.com/api/operations/audit-logs-get-user-audit-logs
     *
     * @param array $params Array containing the necessary params.
     *
     * @return ResponseInterface List Audit Logs response.
     */
    public function list(array $params = []): ResponseInterface
    {
        return $this->getHttpClient()->get('/user/audit_logs', $params);
    }
}
