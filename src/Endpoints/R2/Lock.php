<?php

namespace Cloudflare\Endpoints\R2;

use Cloudflare\Endpoints\AbstractEndpoint;
use Cloudflare\Contracts\ResponseInterface;

class Lock extends AbstractEndpoint
{
    /**
     * Get the object lock configuration for a bucket.
     *
     * @link https://developers.cloudflare.com/api/operations/r2-get-bucket-lock-configuration
     *
     * @param string $accountId Account Identifier.
     * @param string $bucketName Bucket Name.
     * @param string|null $jurisdiction Jurisdiction where objects in this bucket are guaranteed to be stored.
     *
     * @return ResponseInterface Lock configuration response
     */
    public function get(string $accountId, string $bucketName, ?string $jurisdiction = null): ResponseInterface
    {
        return $this->getHttpClient()->get("/accounts/{$accountId}/r2/buckets/{$bucketName}/lock", null, $this->jurisdictionHeader($jurisdiction));
    }

    /**
     * Set the object lock configuration for a bucket.
     *
     * @link https://developers.cloudflare.com/api/operations/r2-put-bucket-lock-configuration
     *
     * @param string $accountId Account Identifier.
     * @param string $bucketName Bucket Name.
     * @param array $rules Lock (retention) rules to set on the bucket.
     * @param string|null $jurisdiction Jurisdiction where objects in this bucket are guaranteed to be stored.
     *
     * @return ResponseInterface Update lock configuration response
     */
    public function update(string $accountId, string $bucketName, array $rules, ?string $jurisdiction = null): ResponseInterface
    {
        return $this->getHttpClient()->put("/accounts/{$accountId}/r2/buckets/{$bucketName}/lock", [
            'rules' => $rules,
        ], $this->jurisdictionHeader($jurisdiction));
    }
}
