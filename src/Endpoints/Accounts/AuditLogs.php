<?php

namespace Cloudflare\Endpoints\Accounts;

use Cloudflare\Endpoints\AbstractEndpoint;
use Cloudflare\Contracts\CloudflareResponse;

class AuditLogs extends AbstractEndpoint
{
    /**
     * Gets a list of audit logs for an account. Can be filtered by who made the change, on which zone, and the timeframe of the change.
     *
     * @link https://developers.cloudflare.com/api/operations/audit-logs-get-account-audit-logs
     *
     * @param string $accountId Account identifier.
     * @param array $params Array containing the necessary params.
     *
     * @return CloudflareResponse Get account audit logs response.
     */
    public function list(string $accountId, array $params = []): CloudflareResponse
    {
        return $this->getHttpClient()->get("/accounts/{$accountId}/audit_logs", $params);
    }
}
