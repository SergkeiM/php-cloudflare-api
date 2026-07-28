<?php

namespace Cloudflare\Endpoints\Accounts;

use Cloudflare\Endpoints\AbstractEndpoint;
use Cloudflare\Contracts\ResponseInterface;

class R2ManagedDomain extends AbstractEndpoint
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
    public function details(string $accountId, string $bucketName, ?string $jurisdiction = null): ResponseInterface
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
