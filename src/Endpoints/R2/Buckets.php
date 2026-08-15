<?php

namespace Cloudflare\Endpoints\R2;

use Cloudflare\Endpoints\AbstractEndpoint;
use Cloudflare\Contracts\ResponseInterface;

class Buckets extends AbstractEndpoint
{
    /**
     * Returns a list of buckets for an account.
     *
     * @link https://developers.cloudflare.com/api/resources/r2/subresources/buckets/methods/list/
     *
     * @param string $accountId Account Identifier.
     * @param array $params Query Parameters.
     * @param string|null $jurisdiction Jurisdiction where objects in this bucket are guaranteed to be stored.
     *
     * @return ResponseInterface List buckets response
     */
    public function list(string $accountId, array $params = [], ?string $jurisdiction = null): ResponseInterface
    {
        return $this->getHttpClient()->get("/accounts/{$accountId}/r2/buckets", $params, $this->jurisdictionHeader($jurisdiction));
    }

    /**
     * Creates a new bucket for an account.
     *
     * @link https://developers.cloudflare.com/api/resources/r2/subresources/buckets/methods/create/
     *
     * @param string $accountId Account Identifier.
     * @param array $values Values to set on the bucket, e.g. `name`, `locationHint`, `storageClass`.
     * @param string|null $jurisdiction Jurisdiction where objects in this bucket are guaranteed to be stored.
     *
     * @return ResponseInterface Create a bucket response
     */
    public function create(string $accountId, array $values, ?string $jurisdiction = null): ResponseInterface
    {
        $this->requiredParams(['name'], $values);

        return $this->getHttpClient()->post("/accounts/{$accountId}/r2/buckets", $values, $this->jurisdictionHeader($jurisdiction));
    }

    /**
     * Get a bucket's details.
     *
     * @link https://developers.cloudflare.com/api/resources/r2/subresources/buckets/methods/get/
     *
     * @param string $accountId Account Identifier.
     * @param string $bucketName Bucket Name.
     * @param string|null $jurisdiction Jurisdiction where objects in this bucket are guaranteed to be stored.
     *
     * @return ResponseInterface Bucket details response
     */
    public function get(string $accountId, string $bucketName, ?string $jurisdiction = null): ResponseInterface
    {
        return $this->getHttpClient()->get("/accounts/{$accountId}/r2/buckets/{$bucketName}", null, $this->jurisdictionHeader($jurisdiction));
    }

    /**
     * Apply changes to the storage class of an existing bucket.
     *
     * @link https://developers.cloudflare.com/api/resources/r2/subresources/buckets/methods/edit/
     *
     * @param string $accountId Account Identifier.
     * @param string $bucketName Bucket Name.
     * @param string $storageClass Storage class to set on the bucket, e.g. `Standard` or `InfrequentAccess`.
     * @param string|null $jurisdiction Jurisdiction where objects in this bucket are guaranteed to be stored.
     *
     * @return ResponseInterface Edit a bucket response
     */
    public function edit(string $accountId, string $bucketName, string $storageClass, ?string $jurisdiction = null): ResponseInterface
    {
        $options = $this->jurisdictionHeader($jurisdiction);
        $options['headers'] = array_merge($options['headers'] ?? [], [
            'cf-r2-storage-class' => $storageClass,
        ]);

        return $this->getHttpClient()->patch("/accounts/{$accountId}/r2/buckets/{$bucketName}", [], $options);
    }

    /**
     * Deletes an existing bucket.
     *
     * @link https://developers.cloudflare.com/api/resources/r2/subresources/buckets/methods/delete/
     *
     * @param string $accountId Account Identifier.
     * @param string $bucketName Bucket Name.
     * @param string|null $jurisdiction Jurisdiction where objects in this bucket are guaranteed to be stored.
     *
     * @return ResponseInterface Delete a bucket response
     */
    public function delete(string $accountId, string $bucketName, ?string $jurisdiction = null): ResponseInterface
    {
        return $this->getHttpClient()->delete("/accounts/{$accountId}/r2/buckets/{$bucketName}", [], $this->jurisdictionHeader($jurisdiction));
    }

    /**
     * Creates temporary access credentials scoped to a specific bucket.
     *
     * @link https://developers.cloudflare.com/api/resources/r2/subresources/temporary_credentials/methods/create/
     *
     * @param string $accountId Account Identifier.
     * @param array $values Values to set, e.g. `bucket`, `permission`, `ttlSeconds`, `parentAccessKeyId`.
     *
     * @return ResponseInterface Create temporary access credentials response
     */
    public function createTemporaryCredentials(string $accountId, array $values): ResponseInterface
    {
        $this->requiredParams(['bucket', 'permission', 'ttlSeconds', 'parentAccessKeyId'], $values);

        return $this->getHttpClient()->post("/accounts/{$accountId}/r2/temp-access-credentials", $values);
    }
}
