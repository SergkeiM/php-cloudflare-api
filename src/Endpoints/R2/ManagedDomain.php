<?php

namespace Cloudflare\Endpoints\R2;

use Cloudflare\Endpoints\AbstractEndpoint;
use Cloudflare\Contracts\ResponseInterface;

class ManagedDomain extends AbstractEndpoint
{
    /**
     * Get the managed (`r2.dev`) domain configuration for a bucket.
     *
     * @link https://developers.cloudflare.com/api/operations/r2-get-bucket-managed-domain
     *
     * @param string $accountId Account Identifier.
     * @param string $bucketName Bucket Name.
     * @param string|null $jurisdiction Jurisdiction where objects in this bucket are guaranteed to be stored.
     *
     * @return ResponseInterface Managed domain details response
     */
    public function get(string $accountId, string $bucketName, ?string $jurisdiction = null): ResponseInterface
    {
        return $this->getHttpClient()->get("/accounts/{$accountId}/r2/buckets/{$bucketName}/domains/managed", null, $this->jurisdictionHeader($jurisdiction));
    }

    /**
     * Enable or disable the managed (`r2.dev`) domain for a bucket.
     *
     * @link https://developers.cloudflare.com/api/operations/r2-edit-bucket-managed-domain
     *
     * @param string $accountId Account Identifier.
     * @param string $bucketName Bucket Name.
     * @param bool $enabled Whether the managed domain is enabled.
     * @param string|null $jurisdiction Jurisdiction where objects in this bucket are guaranteed to be stored.
     *
     * @return ResponseInterface Update managed domain response
     */
    public function update(string $accountId, string $bucketName, bool $enabled, ?string $jurisdiction = null): ResponseInterface
    {
        return $this->getHttpClient()->put("/accounts/{$accountId}/r2/buckets/{$bucketName}/domains/managed", [
            'enabled' => $enabled,
        ], $this->jurisdictionHeader($jurisdiction));
    }
}
