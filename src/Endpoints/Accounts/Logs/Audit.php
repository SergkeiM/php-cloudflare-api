<?php

namespace Cloudflare\Endpoints\Accounts\Logs;

use Cloudflare\Endpoints\AbstractEndpoint;
use Cloudflare\Contracts\ResponseInterface;

class Audit extends AbstractEndpoint
{
    /**
     * Gets a list of audit logs for an account.
     *
     * @link https://developers.cloudflare.com/api/resources/accounts/subresources/logs/subresources/audit/methods/list/
     *
     * @param string $accountId Account identifier.
     * @param array $params Array containing the necessary params, requires since and before.
     *
     * @return ResponseInterface List Audit Logs response.
     */
    public function list(string $accountId, array $params = []): ResponseInterface
    {
        $this->requiredParams(['since', 'before'], $params);

        return $this->getHttpClient()->get("/accounts/{$accountId}/logs/audit", $params);
    }

    /**
     * Returns the chronological change history for the resource identified by the given audit log entry.
     *
     * @link https://developers.cloudflare.com/api/resources/accounts/subresources/logs/subresources/audit/methods/history/
     *
     * @param string $accountId Account identifier.
     * @param string $id Audit log entry identifier used to locate the resource.
     * @param array $params Array containing the necessary params, requires action_time, since and before.
     *
     * @return ResponseInterface Audit Log History response.
     */
    public function history(string $accountId, string $id, array $params = []): ResponseInterface
    {
        $this->requiredParams(['action_time', 'since', 'before'], $params);

        return $this->getHttpClient()->get("/accounts/{$accountId}/logs/audit/{$id}/history", $params);
    }

    /**
     * Lists the available audit log product categories and the resource products each one expands to.
     *
     * @link https://developers.cloudflare.com/api/resources/accounts/subresources/logs/subresources/audit/methods/product_categories/
     *
     * @param string $accountId Account identifier.
     *
     * @return ResponseInterface List Product Categories response.
     */
    public function productCategories(string $accountId): ResponseInterface
    {
        return $this->getHttpClient()->get("/accounts/{$accountId}/logs/audit/product_categories");
    }
}
