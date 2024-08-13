<?php

namespace SergkeiM\CloudFlare\Endpoints;

use SergkeiM\CloudFlare\Contracts\CloudFlareResponse;
use SergkeiM\CloudFlare\Exceptions\InvalidArgumentException;
use SergkeiM\CloudFlare\Exceptions\MissingArgumentException;

/**
 * @link https://developers.cloudflare.com/api/operations/accounts-list-accounts
 */
class Accounts extends AbstractEndpoint
{
    /**
     * List all accounts you have ownership or verified access to.
     *
     * @link https://developers.cloudflare.com/api/operations/accounts-list-accounts
     *
     * @param array $params Array containing the necessary params.
     *
     * @return CloudFlareResponse List Accounts response.
     */
    public function all(array $params = []): CloudFlareResponse
    {
        return $this->sendGet('/accounts', $params);
    }

    /**
     * Get information about a specific account that you are a member of.
     *
     * @link https://developers.cloudflare.com/api/operations/accounts-account-details
     *
     * @param string $accountId Account ID to fetch details.
     *
     * @throws InvalidArgumentException
     *
     * @return CloudFlareResponse Account Details response.
     */
    public function details(string $accountId): CloudFlareResponse
    {

        if(empty($accountId)) {
            throw new InvalidArgumentException('Account ID is required.');
        }

        return $this->sendGet('/accounts/'.rawurlencode($accountId));
    }

    /**
     * Get information about a specific account that you are a member of.
     *
     * @link https://developers.cloudflare.com/api/operations/accounts-update-account
     *
     * @param string $accountId Account ID that you want to update.
     * @param array $values Values to set on account.
     *
     * @throws InvalidArgumentException
     * @throws MissingArgumentException
     *
     * @return CloudFlareResponse Update Account response.
     */
    public function update(string $accountId, array $values): CloudFlareResponse
    {

        if(empty($accountId)) {
            throw new InvalidArgumentException('Account ID is required.');
        }

        if(empty($values['name'])) {
            throw new MissingArgumentException('name');
        }

        return $this->sendPut('/accounts/'.rawurlencode($accountId), $values);
    }
}
