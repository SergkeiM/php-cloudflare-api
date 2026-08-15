<?php

namespace Cloudflare\Endpoints\R2;

use Cloudflare\Endpoints\AbstractEndpoint;
use Cloudflare\Contracts\ResponseInterface;
use GuzzleHttp\RequestOptions;

/**
 * Objects stored in an R2 bucket, over Cloudflare's REST API.
 *
 * Cloudflare recommends R2's S3-compatible API or a Worker with an R2 binding
 * for most workloads; these endpoints exist for the cases where reaching for an
 * S3 client is not worth it. Uploads through this API are capped at 300 MB.
 *
 * @link https://developers.cloudflare.com/r2/api/
 */
class Objects extends AbstractEndpoint
{
    /**
     * List objects in a bucket.
     *
     * @link https://developers.cloudflare.com/r2/api/
     *
     * @param string $accountId Account Identifier.
     * @param string $bucketName Bucket Name.
     * @param array $params Query Parameters: `per_page`, `prefix`, `delimiter`, `cursor` and `start_after`.
     * @param string|null $jurisdiction Jurisdiction where objects in this bucket are guaranteed to be stored.
     *
     * @return ResponseInterface List objects response
     */
    public function list(string $accountId, string $bucketName, array $params = [], ?string $jurisdiction = null): ResponseInterface
    {
        return $this->getHttpClient()->get("/accounts/{$accountId}/r2/buckets/{$bucketName}/objects", $params, $this->jurisdictionHeader($jurisdiction));
    }

    /**
     * Retrieve an object from a bucket.
     *
     * The response carries the object itself, not a JSON envelope, so read it
     * with `body()` rather than `json()`. Object metadata comes back as
     * response headers, reachable through `toPsrResponse()`.
     *
     * ```php
     * $object = $client->r2()->objects()->get('ACCOUNT_ID', 'my-bucket', 'path/to/file.txt');
     *
     * file_put_contents('file.txt', $object->body());
     * ```
     *
     * @link https://developers.cloudflare.com/r2/api/
     *
     * @param string $accountId Account Identifier.
     * @param string $bucketName Bucket Name.
     * @param string $objectKey Key of the object, e.g. `path/to/file.txt`.
     * @param string|null $jurisdiction Jurisdiction where objects in this bucket are guaranteed to be stored.
     *
     * @return ResponseInterface Get object response, the object body itself
     */
    public function get(string $accountId, string $bucketName, string $objectKey, ?string $jurisdiction = null): ResponseInterface
    {
        return $this->getHttpClient()->get("/accounts/{$accountId}/r2/buckets/{$bucketName}/objects/{$objectKey}", null, $this->jurisdictionHeader($jurisdiction));
    }

    /**
     * Upload an object to a bucket.
     *
     * The object is sent as the raw request body, up to 300 MB. Anything larger
     * needs R2's S3-compatible API and its multipart upload.
     *
     * ```php
     * $client->r2()->objects()->upload(
     *     'ACCOUNT_ID',
     *     'my-bucket',
     *     'path/to/file.txt',
     *     file_get_contents('file.txt'),
     *     'text/plain'
     * );
     * ```
     *
     * @link https://developers.cloudflare.com/r2/api/
     *
     * @param string $accountId Account Identifier.
     * @param string $bucketName Bucket Name.
     * @param string $objectKey Key to store the object under, e.g. `path/to/file.txt`.
     * @param string $contents The object itself.
     * @param string $contentType Media type of the object.
     * @param string|null $storageClass Storage class to store the object as, e.g. `Standard` or `InfrequentAccess`. Defaults to the bucket's own.
     * @param string|null $jurisdiction Jurisdiction where objects in this bucket are guaranteed to be stored.
     *
     * @return ResponseInterface Upload object response
     */
    public function upload(
        string $accountId,
        string $bucketName,
        string $objectKey,
        string $contents,
        string $contentType = 'application/octet-stream',
        ?string $storageClass = null,
        ?string $jurisdiction = null
    ): ResponseInterface {

        $options = $this->jurisdictionHeader($jurisdiction);

        $options['headers'] = array_merge($options['headers'] ?? [], array_filter([
            'Content-Type' => $contentType,
            'cf-r2-storage-class' => $storageClass,
        ]));

        return $this->getHttpClient()->put(
            "/accounts/{$accountId}/r2/buckets/{$bucketName}/objects/{$objectKey}",
            $contents,
            $options,
            format: RequestOptions::BODY
        );
    }

    /**
     * Delete a single object from a bucket.
     *
     * @link https://developers.cloudflare.com/r2/api/
     *
     * @param string $accountId Account Identifier.
     * @param string $bucketName Bucket Name.
     * @param string $objectKey Key of the object to delete.
     * @param string|null $jurisdiction Jurisdiction where objects in this bucket are guaranteed to be stored.
     *
     * @return ResponseInterface Delete object response
     */
    public function delete(string $accountId, string $bucketName, string $objectKey, ?string $jurisdiction = null): ResponseInterface
    {
        return $this->getHttpClient()->delete("/accounts/{$accountId}/r2/buckets/{$bucketName}/objects/{$objectKey}", [], $this->jurisdictionHeader($jurisdiction));
    }

    /**
     * Delete a list of objects from a bucket.
     *
     * Every key given is deleted, and Cloudflare reports failures per key in
     * the response rather than failing the whole request.
     *
     * @link https://developers.cloudflare.com/r2/api/
     *
     * @param string $accountId Account Identifier.
     * @param string $bucketName Bucket Name.
     * @param array $objectKeys Keys of the objects to delete.
     * @param string|null $jurisdiction Jurisdiction where objects in this bucket are guaranteed to be stored.
     *
     * @return ResponseInterface Delete objects response
     */
    public function deleteMany(string $accountId, string $bucketName, array $objectKeys, ?string $jurisdiction = null): ResponseInterface
    {
        // Cloudflare wants a bare JSON array of keys, so the list is the body.
        return $this->getHttpClient()->delete(
            "/accounts/{$accountId}/r2/buckets/{$bucketName}/objects",
            array_values($objectKeys),
            $this->jurisdictionHeader($jurisdiction)
        );
    }

    /**
     * Delete every object whose key begins with a prefix.
     *
     * Cloudflare answers with a job descriptor rather than doing the work
     * inline: small jobs may come back already `COMPLETED`, larger ones keep
     * running in the background, so poll the `id` you get back with
     * `$client->r2()->jobs()->get()`. Objects written after the job starts are
     * not included in it.
     *
     * @link https://developers.cloudflare.com/r2/api/
     *
     * @param string $accountId Account Identifier.
     * @param string $bucketName Bucket Name.
     * @param string $prefix Key prefix to delete under. Pass an empty string to delete every object — or use `emptyBucket()`, which says so plainly.
     * @param bool $dataCatalogCheck Refuse the request with a `409` if R2 Data Catalog is enabled on the bucket.
     * @param string|null $jurisdiction Jurisdiction where objects in this bucket are guaranteed to be stored.
     *
     * @return ResponseInterface Delete objects by prefix response, a job descriptor
     */
    public function deleteByPrefix(
        string $accountId,
        string $bucketName,
        string $prefix,
        bool $dataCatalogCheck = false,
        ?string $jurisdiction = null
    ): ResponseInterface {

        $options = $this->jurisdictionHeader($jurisdiction);

        if ($dataCatalogCheck) {
            $options['headers'] = array_merge($options['headers'] ?? [], [
                'cf-r2-data-catalog-check' => 'true',
            ]);
        }

        // The prefix goes in the query string, and the body stays empty — that
        // is what tells Cloudflare this is not a delete-by-list request.
        $options['query'] = ['prefix' => $prefix];

        return $this->getHttpClient()->delete("/accounts/{$accountId}/r2/buckets/{$bucketName}/objects", [], $options);
    }

    /**
     * Delete every object in a bucket.
     *
     * The same operation as `deleteByPrefix()` with an empty prefix, and it
     * behaves the same way: you get a job descriptor back to poll with
     * `$client->r2()->jobs()->get()`.
     *
     * Cloudflare refuses to empty a bucket that has event notifications
     * configured, answering `409` with error code `10034` — remove the
     * notification rules first. Abort any active multipart uploads before
     * submitting, and avoid writing to the bucket while the job runs.
     *
     * @link https://developers.cloudflare.com/r2/api/
     *
     * @param string $accountId Account Identifier.
     * @param string $bucketName Bucket Name.
     * @param bool $dataCatalogCheck Refuse the request with a `409` if R2 Data Catalog is enabled on the bucket.
     * @param string|null $jurisdiction Jurisdiction where objects in this bucket are guaranteed to be stored.
     *
     * @return ResponseInterface Empty bucket response, a job descriptor
     */
    public function emptyBucket(
        string $accountId,
        string $bucketName,
        bool $dataCatalogCheck = false,
        ?string $jurisdiction = null
    ): ResponseInterface {
        return $this->deleteByPrefix($accountId, $bucketName, '', $dataCatalogCheck, $jurisdiction);
    }
}
