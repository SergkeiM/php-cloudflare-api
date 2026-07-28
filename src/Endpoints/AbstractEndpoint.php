<?php

namespace Cloudflare\Endpoints;

use Cloudflare\Client;
use Cloudflare\HttpClient\HttpClient;
use Cloudflare\Exceptions\MissingArgumentException;
use Cloudflare\Exceptions\InvalidArgumentException;

abstract class AbstractEndpoint
{
    /**
     * Create a new API instance.
     */
    public function __construct(
        private readonly Client $client
    ) {
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

    /**
     * @param array $keys
     * @param array $values
     *
     * @throws MissingArgumentException
     * @return void
     */
    protected function requiredAnyParams(array $keys, array $values): void
    {
        foreach ($keys as $key) {
            if (isset($values[$key]) && !empty($values[$key])) {
                return;
            }
        }

        throw new MissingArgumentException($keys);
    }

    /**
     * Resolve a resource path prefix for a resource scoped to either an account or a zone,
     * exactly one of which must be provided.
     *
     * @param string|null $accountId
     * @param string|null $zoneId
     *
     * @throws InvalidArgumentException
     * @return string
     */
    protected function scopePath(?string $accountId, ?string $zoneId): string
    {
        if (($accountId === null) === ($zoneId === null)) {
            throw new InvalidArgumentException('Provide exactly one of $accountId or $zoneId.');
        }

        return $accountId !== null ? "/accounts/{$accountId}" : "/zones/{$zoneId}";
    }

    /**
     * Build the optional `cf-r2-jurisdiction` header.
     *
     * @param string|null $jurisdiction
     *
     * @return array
     */
    protected function jurisdictionHeader(?string $jurisdiction): array
    {
        return $jurisdiction === null ? [] : ['headers' => ['cf-r2-jurisdiction' => $jurisdiction]];
    }
}
