<?php

namespace SergkeiM\CloudFlare\Endpoints\Zones;

use SergkeiM\CloudFlare\Endpoints\AbstractEndpoint;
use SergkeiM\CloudFlare\Contracts\CloudFlareResponse;
use SergkeiM\CloudFlare\Exceptions\InvalidArgumentException;
use SergkeiM\CloudFlare\Exceptions\MissingArgumentException;

class CloudConnector extends AbstractEndpoint
{
    /**
     * @link https://developers.cloudflare.com/api/operations/zone-cloud-connector-rules
     *
     * @param string $zoneId Zone ID.
     *
     * @return CloudFlareResponse Cloud Connector rules response.
     */
    public function get(string $zoneId): CloudFlareResponse
    {

        if(empty($zoneId)) {
            throw new InvalidArgumentException('Zone ID is required.');
        }

        return $this->sendGet('/zones/'.rawurlencode($zoneId).'/cloud_connector/rules');
    }

    /**
     * @link https://developers.cloudflare.com/api/operations/zone-cloud-conenctor-rules-put
     *
     * @param string $zoneId Zone ID.
     * @param array $values List of Cloud Connector rules.
     *
     * @throws InvalidArgumentException
     * @throws MissingArgumentException
     *
     * @return CloudFlareResponse Cloud Connector rules response.
     */
    public function update(string $zoneId, array $values): CloudFlareResponse
    {

        if(empty($accountId)) {
            throw new InvalidArgumentException('Account ID is required.');
        }

        if(empty($values['name'])) {
            throw new MissingArgumentException('name');
        }

        return $this->sendPut('/zones/'.rawurlencode($zoneId).'/cloud_connector/rules', $values);
    }
}
