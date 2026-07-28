<?php

namespace Cloudflare\Endpoints\R2;

use Cloudflare\Endpoints\AbstractEndpoint;
use Cloudflare\Contracts\ResponseInterface;

class Cors extends AbstractEndpoint
{
    /**
     * Get the CORS configuration for a bucket.
     *
     * @link https://developers.cloudflare.com/api/operations/r2-get-bucket-cors-policy
     *
     * @param string $accountId Account Identifier.
     * @param string $bucketName Bucket Name.
     * @param string|null $jurisdiction Jurisdiction where objects in this bucket are guaranteed to be stored.
     *
     * @return ResponseInterface CORS configuration response
     */
    public function get(string $accountId, string $bucketName, ?string $jurisdiction = null): ResponseInterface
    {
        return $this->getHttpClient()->get("/accounts/{$accountId}/r2/buckets/{$bucketName}/cors", null, $this->jurisdictionHeader($jurisdiction));
    }

    /**
     * Set the CORS configuration for a bucket.
     *
     * @link https://developers.cloudflare.com/api/operations/r2-put-bucket-cors-policy
     *
     * @param string $accountId Account Identifier.
     * @param string $bucketName Bucket Name.
     * @param array $rules CORS rules to set on the bucket.
     * @param string|null $jurisdiction Jurisdiction where objects in this bucket are guaranteed to be stored.
     *
     * @return ResponseInterface Update CORS configuration response
     */
    public function update(string $accountId, string $bucketName, array $rules, ?string $jurisdiction = null): ResponseInterface
    {
        return $this->getHttpClient()->put("/accounts/{$accountId}/r2/buckets/{$bucketName}/cors", [
            'rules' => $rules,
        ], $this->jurisdictionHeader($jurisdiction));
    }

    /**
     * Delete the CORS configuration for a bucket.
     *
     * @link https://developers.cloudflare.com/api/operations/r2-delete-bucket-cors-policy
     *
     * @param string $accountId Account Identifier.
     * @param string $bucketName Bucket Name.
     * @param string|null $jurisdiction Jurisdiction where objects in this bucket are guaranteed to be stored.
     *
     * @return ResponseInterface Delete CORS configuration response
     */
    public function delete(string $accountId, string $bucketName, ?string $jurisdiction = null): ResponseInterface
    {
        return $this->getHttpClient()->delete("/accounts/{$accountId}/r2/buckets/{$bucketName}/cors", [], $this->jurisdictionHeader($jurisdiction));
    }
}
