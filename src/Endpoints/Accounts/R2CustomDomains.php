<?php

namespace Cloudflare\Endpoints\Accounts;

use Cloudflare\Endpoints\AbstractEndpoint;
use Cloudflare\Contracts\ResponseInterface;

class R2CustomDomains extends AbstractEndpoint
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
     * List custom domains for a bucket.
     *
     * @link https://developers.cloudflare.com/api/operations/r2-list-bucket-domains
     *
     * @param string $accountId Account Identifier.
     * @param string $bucketName Bucket Name.
     * @param string|null $jurisdiction Jurisdiction where objects in this bucket are guaranteed to be stored.
     *
     * @return ResponseInterface List custom domains response
     */
    public function list(string $accountId, string $bucketName, ?string $jurisdiction = null): ResponseInterface
    {
        return $this->getHttpClient()->get("/accounts/{$accountId}/r2/buckets/{$bucketName}/domains/custom", null, $this->jurisdictionHeader($jurisdiction));
    }

    /**
     * Add a custom domain to a bucket.
     *
     * @link https://developers.cloudflare.com/api/operations/r2-add-bucket-domain
     *
     * @param string $accountId Account Identifier.
     * @param string $bucketName Bucket Name.
     * @param array $values Values to set, e.g. `domain`, `zoneId`, `enabled`.
     * @param string|null $jurisdiction Jurisdiction where objects in this bucket are guaranteed to be stored.
     *
     * @return ResponseInterface Add custom domain response
     */
    public function create(string $accountId, string $bucketName, array $values, ?string $jurisdiction = null): ResponseInterface
    {
        $this->requiredParams(['domain', 'zoneId', 'enabled'], $values);

        return $this->getHttpClient()->post("/accounts/{$accountId}/r2/buckets/{$bucketName}/domains/custom", $values, $this->jurisdictionHeader($jurisdiction));
    }

    /**
     * Get an existing custom domain for a bucket.
     *
     * @link https://developers.cloudflare.com/api/operations/r2-get-bucket-domain
     *
     * @param string $accountId Account Identifier.
     * @param string $bucketName Bucket Name.
     * @param string $domain Custom domain name.
     * @param string|null $jurisdiction Jurisdiction where objects in this bucket are guaranteed to be stored.
     *
     * @return ResponseInterface Custom domain details response
     */
    public function details(string $accountId, string $bucketName, string $domain, ?string $jurisdiction = null): ResponseInterface
    {
        return $this->getHttpClient()->get("/accounts/{$accountId}/r2/buckets/{$bucketName}/domains/custom/{$domain}", null, $this->jurisdictionHeader($jurisdiction));
    }

    /**
     * Update an existing custom domain for a bucket.
     *
     * @link https://developers.cloudflare.com/api/operations/r2-edit-bucket-domain
     *
     * @param string $accountId Account Identifier.
     * @param string $bucketName Bucket Name.
     * @param string $domain Custom domain name.
     * @param array $values Values to set, e.g. `enabled`, `minTLS`, `ciphers`.
     * @param string|null $jurisdiction Jurisdiction where objects in this bucket are guaranteed to be stored.
     *
     * @return ResponseInterface Update custom domain response
     */
    public function update(string $accountId, string $bucketName, string $domain, array $values, ?string $jurisdiction = null): ResponseInterface
    {
        return $this->getHttpClient()->put("/accounts/{$accountId}/r2/buckets/{$bucketName}/domains/custom/{$domain}", $values, $this->jurisdictionHeader($jurisdiction));
    }

    /**
     * Remove a custom domain from a bucket.
     *
     * @link https://developers.cloudflare.com/api/operations/r2-remove-bucket-domain
     *
     * @param string $accountId Account Identifier.
     * @param string $bucketName Bucket Name.
     * @param string $domain Custom domain name.
     * @param string|null $jurisdiction Jurisdiction where objects in this bucket are guaranteed to be stored.
     *
     * @return ResponseInterface Remove custom domain response
     */
    public function delete(string $accountId, string $bucketName, string $domain, ?string $jurisdiction = null): ResponseInterface
    {
        return $this->getHttpClient()->delete("/accounts/{$accountId}/r2/buckets/{$bucketName}/domains/custom/{$domain}", [], $this->jurisdictionHeader($jurisdiction));
    }
}
