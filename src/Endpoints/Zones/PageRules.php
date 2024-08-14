<?php

namespace SergkeiM\CloudFlare\Endpoints\Zones;

use SergkeiM\CloudFlare\Endpoints\AbstractEndpoint;
use SergkeiM\CloudFlare\Contracts\CloudFlareResponse;
use SergkeiM\CloudFlare\Exceptions\InvalidArgumentException;
use SergkeiM\CloudFlare\Exceptions\MissingArgumentException;

class PageRules extends AbstractEndpoint
{
    /**
     * List Page Rules in a zone.
     *
     * @link https://developers.cloudflare.com/api/operations/page-rules-list-page-rules
     *
     * @param string $zoneId Zone ID to list DNS records.
     * @param array $params Query Parameters
     *
     * @throws InvalidArgumentException
     *
     * @return CloudFlareResponse List Page Rules response
     */
    public function all(string $zoneId, array $params = []): CloudFlareResponse
    {
        if(empty($zoneId)) {
            throw new InvalidArgumentException('Zone ID is required.');
        }

        return $this->getHttpClient()->get('/zones/'.rawurlencode($zoneId).'/pagerules', $params);
    }

    /**
     * Create a Page Rule
     *
     * @link https://developers.cloudflare.com/api/operations/page-rules-create-a-page-rule
     *
     * @param string $zoneId Zone ID that you want to create a new Page Rule for.
     * @param array $values Values to set on Page Rule.
     *
     * @throws InvalidArgumentException
     * @throws MissingArgumentException
     *
     * @return CloudFlareResponse Create a Page Rule response
     */
    public function create(string $zoneId, array $values): CloudFlareResponse
    {

        if(empty($zoneId)) {
            throw new InvalidArgumentException('Zone ID is required.');
        }

        if(
            empty($values['actions']) ||
            empty($values['targets'])
        ) {
            throw new MissingArgumentException(['actions', 'targets']);
        }

        return $this->$this->getHttpClient()->post('/zones/'.rawurlencode($zoneId).'/dns_records', $values);
    }

    /**
     * Fetches the details of a Page Rule.
     *
     * @link https://developers.cloudflare.com/api/operations/page-rules-get-a-page-rule
     *
     * @param string $zoneId Zone ID to fetch details.
     * @param string $pageruleId Page Rule ID to fetch details.
     *
     * @throws InvalidArgumentException
     *
     * @return CloudFlareResponse Get a Page Rule response
     */
    public function details(string $zoneId, string $pageruleId): CloudFlareResponse
    {

        if(empty($zoneId)) {
            throw new InvalidArgumentException('Zone ID is required.');
        }

        if(empty($pageruleId)) {
            throw new InvalidArgumentException('DNS ID is required.');
        }

        return $this->getHttpClient()->get('/zones/'.rawurlencode($zoneId).'/pagerules/'.rawurlencode($pageruleId));
    }

    /**
     * Updates one or more fields of an existing Page Rule.
     *
     * @link https://developers.cloudflare.com/api/operations/page-rules-edit-a-page-rule
     *
     * @param string $zoneId Zone ID to update Page Rule on.
     * @param string $pageruleId Page Rule ID to update.
     *
     * @throws InvalidArgumentException
     * @throws MissingArgumentException
     *
     * @return CloudFlareResponse Edit a Page Rule response
     */
    public function update(string $zoneId, string $pageruleId, array $values): CloudFlareResponse
    {

        if(empty($zoneId)) {
            throw new InvalidArgumentException('Zone ID is required.');
        }

        if(empty($pageruleId)) {
            throw new InvalidArgumentException('Page Rule ID.');
        }

        return $this->getHttpClient()->patch('/zones/'.rawurlencode($zoneId).'/pagerules/'.rawurlencode($pageruleId), $values);
    }

    /**
     * Replaces the configuration of an existing Page Rule. The configuration of the updated Page Rule will exactly match the data passed in the API request.
     *
     * @link https://developers.cloudflare.com/api/operations/page-rules-update-a-page-rule
     *
     * @param string $zoneId Zone ID to overwrite Page Rule on.
     * @param string $pageruleId Page Rule ID to overwrite.
     *
     * @throws InvalidArgumentException
     * @throws MissingArgumentException
     *
     * @return CloudFlareResponse Overwrite Page Rule response
     */
    public function overwrite(string $zoneId, string $pageruleId, array $values): CloudFlareResponse
    {

        if(empty($zoneId)) {
            throw new InvalidArgumentException('Zone ID is required.');
        }

        if(empty($pageruleId)) {
            throw new InvalidArgumentException('DNS ID is required.');
        }

        if(
            empty($values['actions']) ||
            empty($values['targets'])
        ) {
            throw new MissingArgumentException(['actions', 'targets']);
        }

        return $this->getHttpClient()->put('/zones/'.rawurlencode($zoneId).'/pagerules/'.rawurlencode($pageruleId), $values);
    }

    /**
     * Delete a Page Rule
     *
     * @link https://developers.cloudflare.com/api/operations/page-rules-delete-a-page-rule
     *
     * @param string $zoneId Zone ID that you want to delete Page Rule for.
     * @param string $pageruleId Page Rule ID to delete.
     *
     * @throws InvalidArgumentException
     *
     * @return CloudFlareResponse Delete a Page Rule response
     */
    public function delete(string $zoneId, string $pageruleId): CloudFlareResponse
    {

        if(empty($zoneId)) {
            throw new InvalidArgumentException('Zone ID is required.');
        }

        if(empty($pageruleId)) {
            throw new InvalidArgumentException('Page Rule ID is required.');
        }

        return $this->getHttpClient()->delete('/zones/'.rawurlencode($zoneId).'/pagerules/'.rawurlencode($pageruleId));
    }
}
