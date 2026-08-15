<?php

namespace Cloudflare\Endpoints\R2;

use Cloudflare\Endpoints\AbstractEndpoint;
use Cloudflare\Contracts\ResponseInterface;

class CustomDomains extends AbstractEndpoint
{
    /**
     * List custom domains for a bucket.
     *
     * @link https://developers.cloudflare.com/api/resources/r2/subresources/buckets/subresources/domains/subresources/custom/methods/list/
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
     * @link https://developers.cloudflare.com/api/resources/r2/subresources/buckets/subresources/domains/subresources/custom/methods/create/
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
     * @link https://developers.cloudflare.com/api/resources/r2/subresources/buckets/subresources/domains/subresources/custom/methods/get/
     *
     * @param string $accountId Account Identifier.
     * @param string $bucketName Bucket Name.
     * @param string $domain Custom domain name.
     * @param string|null $jurisdiction Jurisdiction where objects in this bucket are guaranteed to be stored.
     *
     * @return ResponseInterface Custom domain details response
     */
    public function get(string $accountId, string $bucketName, string $domain, ?string $jurisdiction = null): ResponseInterface
    {
        return $this->getHttpClient()->get("/accounts/{$accountId}/r2/buckets/{$bucketName}/domains/custom/{$domain}", null, $this->jurisdictionHeader($jurisdiction));
    }

    /**
     * Update an existing custom domain for a bucket.
     *
     * @link https://developers.cloudflare.com/api/resources/r2/subresources/buckets/subresources/domains/subresources/custom/methods/update/
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
     * @link https://developers.cloudflare.com/api/resources/r2/subresources/buckets/subresources/domains/subresources/custom/methods/delete/
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
