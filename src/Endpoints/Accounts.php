<?php

namespace SergkeiM\CloudFlare\Endpoints;

/**
 * @link https://developers.cloudflare.com/api/operations/accounts-list-accounts
 */
class Accounts extends AbstractApi
{
    /**
     * List all accounts you have ownership or verified access to.
     *
     * @link https://developers.cloudflare.com/api/operations/accounts-list-accounts
     *
     * @return array list of accounts found
     */
    public function all(): array
    {
        return $this->get('/accounts');
    }

    /**
     * Get information about a specific account that you are a member of.
     *
     * @link https://developers.cloudflare.com/api/operations/accounts-account-details
     *
     * @param string $accountId Account ID that you are a member of.
     *
     * @return array Account information
     */
    public function details(string $accountId): array
    {
        return $this->get('/accounts/'.rawurlencode($accountId));
    }

    /**
     * Get information about a specific account that you are a member of.
     *
     * @link https://developers.cloudflare.com/api/operations/accounts-update-account
     *
     * @param string $username Account ID that you are a member of.
     *
     * @return array information about the Account
     */
    public function update(string $accountId, array $values): array
    {
        return $this->put('/accounts/'.rawurlencode($accountId), $values);
    }
}
