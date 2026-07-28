<?php

namespace Cloudflare\Endpoints\Accounts;

use Cloudflare\Endpoints\AbstractEndpoint;
use Cloudflare\Contracts\ResponseInterface;

class R2Lifecycle extends AbstractEndpoint
{
    /**
     * Build the optional `cf-r2-jurisdiction` header.
     *
     * @param string|null $jurisdiction
     *
     * @return array
     */
    private function jurisdictionHeader(?string $jurisdiction): array
    {
        return $jurisdiction === null ? [] : ['headers' => ['cf-r2-jurisdiction' => $jurisdiction]];
    }

    /**
     * Get the lifecycle configuration for a bucket.
     *
     * @link https://developers.cloudflare.com/api/operations/r2-get-bucket-lifecycle-configuration
     *
     * @param string $accountId Account Identifier.
     * @param string $bucketName Bucket Name.
     * @param string|null $jurisdiction Jurisdiction where objects in this bucket are guaranteed to be stored.
     *
     * @return ResponseInterface Lifecycle configuration response
     */
    public function details(string $accountId, string $bucketName, ?string $jurisdiction = null): ResponseInterface
    {
        return $this->getHttpClient()->get("/accounts/{$accountId}/r2/buckets/{$bucketName}/lifecycle", null, $this->jurisdictionHeader($jurisdiction));
    }

    /**
     * Set the lifecycle configuration for a bucket.
     *
     * @link https://developers.cloudflare.com/api/operations/r2-put-bucket-lifecycle-configuration
     *
     * @param string $accountId Account Identifier.
     * @param string $bucketName Bucket Name.
     * @param array $rules Lifecycle rules to set on the bucket.
     * @param string|null $jurisdiction Jurisdiction where objects in this bucket are guaranteed to be stored.
     *
     * @return ResponseInterface Update lifecycle configuration response
     */
    public function update(string $accountId, string $bucketName, array $rules, ?string $jurisdiction = null): ResponseInterface
    {
        return $this->getHttpClient()->put("/accounts/{$accountId}/r2/buckets/{$bucketName}/lifecycle", [
            'rules' => $rules,
        ], $this->jurisdictionHeader($jurisdiction));
    }
}
