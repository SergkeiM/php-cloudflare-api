<?php

namespace SergkeiM\CloudFlare\Endpoints;

use SergkeiM\CloudFlare\Client;
use SergkeiM\CloudFlare\HttpClient\HttpClient;
use SergkeiM\CloudFlare\Exceptions\MissingArgumentException;

abstract class AbstractEndpoint
{
    /**
     * @var Client $client
     */
    private $client;
    /**
     * Create a new API instance.
     *
     * @param Client $client
     *
     * @return void
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Get the client instance.
     *
     * @return Client
     */
    protected function getClient(): Client
    {
        return $this->client;
    }

    /**
     * Get the client instance.
     *
     * @return HttpClient
     */
    protected function getHttpClient(): HttpClient
    {
        return $this->client->getHttpClient();
    }

    /**
     * @param array $keys
     * @param array $values
     *
     * @throws MissingArgumentException
     * @return void
     */
    protected function requiredParams(array $keys, array $values): void
    {
        foreach ($keys as $key) {
            if (!isset($values[$key]) || empty($values[$key])) {
                throw new MissingArgumentException($keys);
            }
        }
    }
}
