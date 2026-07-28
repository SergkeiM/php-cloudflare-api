<?php

namespace Cloudflare\Endpoints\R2;

use Cloudflare\Endpoints\AbstractEndpoint;
use Cloudflare\Contracts\ResponseInterface;

class Sippy extends AbstractEndpoint
{
    /**
     * Get the Sippy configuration for a bucket.
     *
     * @link https://developers.cloudflare.com/api/operations/r2-get-bucket-sippy-configuration
     *
     * @param string $accountId Account Identifier.
     * @param string $bucketName Bucket Name.
     * @param string|null $jurisdiction Jurisdiction where objects in this bucket are guaranteed to be stored.
     *
     * @return ResponseInterface Sippy configuration response
     */
    public function get(string $accountId, string $bucketName, ?string $jurisdiction = null): ResponseInterface
    {
        return $this->getHttpClient()->get("/accounts/{$accountId}/r2/buckets/{$bucketName}/sippy", null, $this->jurisdictionHeader($jurisdiction));
    }

    /**
     * Enable Sippy (incremental migration) for a bucket.
     *
     * @link https://developers.cloudflare.com/api/operations/r2-put-bucket-sippy-configuration
     *
     * @param string $accountId Account Identifier.
     * @param string $bucketName Bucket Name.
     * @param array $values Values to set, e.g. `source`, `destination`.
     * @param string|null $jurisdiction Jurisdiction where objects in this bucket are guaranteed to be stored.
     *
     * @return ResponseInterface Enable Sippy response
     */
    public function update(string $accountId, string $bucketName, array $values, ?string $jurisdiction = null): ResponseInterface
    {
        return $this->getHttpClient()->put("/accounts/{$accountId}/r2/buckets/{$bucketName}/sippy", $values, $this->jurisdictionHeader($jurisdiction));
    }

    /**
     * Disable Sippy for a bucket.
     *
     * @link https://developers.cloudflare.com/api/operations/r2-delete-bucket-sippy-configuration
     *
     * @param string $accountId Account Identifier.
     * @param string $bucketName Bucket Name.
     * @param string|null $jurisdiction Jurisdiction where objects in this bucket are guaranteed to be stored.
     *
     * @return ResponseInterface Disable Sippy response
     */
    public function delete(string $accountId, string $bucketName, ?string $jurisdiction = null): ResponseInterface
    {
        return $this->getHttpClient()->delete("/accounts/{$accountId}/r2/buckets/{$bucketName}/sippy", [], $this->jurisdictionHeader($jurisdiction));
    }
}
