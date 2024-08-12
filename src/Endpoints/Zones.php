<?php

namespace SergkeiM\CloudFlare\Endpoints;

use SergkeiM\CloudFlare\Contracts\CloudFlareResponse;
use SergkeiM\CloudFlare\Exceptions\InvalidArgumentException;
use SergkeiM\CloudFlare\Exceptions\MissingArgumentException;
use SergkeiM\CloudFlare\Endpoints\Zones\Cache;
use SergkeiM\CloudFlare\Endpoints\Zones\CloudConnector;

/**
 * @link https://developers.cloudflare.com/api/operations/zones-get
 */
class Zones extends AbstractEndpoint
{
    /**
     * Lists, searches, sorts, and filters your zones. Listing zones across more than 500 accounts is currently not allowed.
     *
     * @link https://developers.cloudflare.com/api/operations/zones-get
     *
     * @param array $params Query Parameters.
     *
     * @return CloudFlareResponse List zones of account found.
     */
    public function all(array $params = []): CloudFlareResponse
    {
        return $this->get('/zones', $params);
    }

    /**
     * Create Zone
     *
     * @link https://developers.cloudflare.com/api/operations/zones-post
     *
     * @param array $values Values to set on zone.
     *
     * @throws InvalidArgumentException
     * @throws MissingArgumentException
     *
     * @return CloudFlareResponse Create Zone response.
     */
    public function create(string $accountId, array $values): CloudFlareResponse
    {

        if(empty($accountId)) {
            throw new InvalidArgumentException('Account ID is required.');
        }

        if(empty($values['name'])) {
            throw new MissingArgumentException('name');
        }

        $params = [
            ...$values,
            'account' => [
                'id' => $accountId
            ]
        ];

        return $this->post('/zones', $params);
    }

    /**
     * Delete Zone
     *
     * @link https://developers.cloudflare.com/api/operations/zones-0-delete
     *
     * @param string $zoneId Zone ID that you want to delete.
     *
     * @throws InvalidArgumentException
     *
     * @return CloudFlareResponse Delete Zone response.
     */
    public function delete(string $zoneId): CloudFlareResponse
    {

        if(empty($zoneId)) {
            throw new InvalidArgumentException('Zone ID is required.');
        }

        return $this->sendDelete('/zones/'.rawurlencode($zoneId));
    }

    /**
     * Zone Details
     *
     * @link https://developers.cloudflare.com/api/operations/zones-0-get
     *
     * @param string $zoneId Zone ID to fetch details.
     *
     * @throws InvalidArgumentException
     *
     * @return CloudFlareResponse Zone Details response.
     */
    public function details(string $zoneId): CloudFlareResponse
    {

        if(empty($zoneId)) {
            throw new InvalidArgumentException('Zone ID is required.');
        }

        return $this->get('/zones/'.rawurlencode($zoneId));
    }

    /**
     * Edit Zone
     *
     * @link https://developers.cloudflare.com/api/operations/zones-0-patch
     *
     * @param string $zoneId Zone ID to update.
     *
     * @throws InvalidArgumentException
     *
     * @return CloudFlareResponse Edit Zone response.
     */
    public function update(string $zoneId, array $values): CloudFlareResponse
    {

        if(empty($zoneId)) {
            throw new InvalidArgumentException('Zone ID is required.');
        }

        return $this->patch('/zones/'.rawurlencode($zoneId), $values);
    }

    /**
     * Triggeres a new activation check for a PENDING Zone. This can be triggered every 5 min for paygo/ent customers, every hour for FREE Zones.
     *
     * @link https://developers.cloudflare.com/api/operations/put-zones-zone_id-activation_check
     *
     * @param string $zoneId Zone ID to trigger Activation Check.
     *
     * @throws InvalidArgumentException
     *
     * @return CloudFlareResponse Activation Check Response
     */
    public function activationCheck(string $zoneId): CloudFlareResponse
    {

        if(empty($zoneId)) {
            throw new InvalidArgumentException('Zone ID is required.');
        }

        return $this->put('/zones/'.rawurlencode($zoneId).'/activation_check');
    }

    /**
     * Purge Cached Content
     *
     * @link https://developers.cloudflare.com/api/operations/zone-purge
     *
     * @param string $zoneId Zone ID to purge cache.
     * @param array $purgeBy Any of: tags, hostnames, prefixes, everything, files
     *
     * @throws InvalidArgumentException
     * @throws MissingArgumentException
     *
     * @return CloudFlareResponse Purge Cached Content Response
     */
    public function purge(string $zoneId, array $purgeBy): CloudFlareResponse
    {

        if(empty($zoneId)) {
            throw new InvalidArgumentException('Zone ID is required.');
        }

        if(
            empty($purgeBy['files']) &&
            empty($purgeBy['tags']) &&
            empty($purgeBy['hosts']) &&
            empty($purgeBy['prefixes'])
        ) {
            throw new MissingArgumentException(['files', 'tags', 'hosts', 'prefixes']);
        }

        return $this->post('/zones/'.rawurlencode($zoneId).'/purge_cache', $purgeBy);
    }

    /**
     * Zone cache settings
     * 
     * @return Cache 
     */
    public function cache(): Cache
    {
        return new Cache($this->getClient());
    }

    /**
     * Zone Cloud Connector rules
     * 
     * @return CloudConnector 
     */
    public function cloudConnector(): CloudConnector
    {
        return new CloudConnector($this->getClient());
    }
}
