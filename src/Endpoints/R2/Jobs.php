<?php

namespace Cloudflare\Endpoints\R2;

use Cloudflare\Endpoints\AbstractEndpoint;
use Cloudflare\Contracts\ResponseInterface;

/**
 * Background jobs on an R2 bucket.
 *
 * Deleting objects by prefix and emptying a bucket are asynchronous: they
 * return a job descriptor, and these endpoints are how you follow it to
 * `COMPLETED`, `FAILED` or `CANCELLED`.
 *
 * @link https://developers.cloudflare.com/r2/api/
 */
class Jobs extends AbstractEndpoint
{
    /**
     * List background jobs for a bucket.
     *
     * @link https://developers.cloudflare.com/r2/api/
     *
     * @param string $accountId Account Identifier.
     * @param string $bucketName Bucket Name.
     * @param array $params Query Parameters: `jobType` (`prefixDelete`), `status` (`ENQUEUED`, `RUNNING`, `COMPLETED`, `FAILED` or `CANCELLED`, and only accepted alongside `jobType`), `maxKeys`, and `continuationToken` from the previous response's `nextContinuationToken`.
     * @param string|null $jurisdiction Jurisdiction where objects in this bucket are guaranteed to be stored.
     *
     * @return ResponseInterface List bucket jobs response
     */
    public function list(string $accountId, string $bucketName, array $params = [], ?string $jurisdiction = null): ResponseInterface
    {
        return $this->getHttpClient()->get("/accounts/{$accountId}/r2/buckets/{$bucketName}/jobs", $params, $this->jurisdictionHeader($jurisdiction));
    }

    /**
     * Get the current status of a background job.
     *
     * ```php
     * $job = $client->r2()->objects()->emptyBucket('ACCOUNT_ID', 'my-bucket')->json('result.id');
     *
     * $status = $client->r2()->jobs()->get('ACCOUNT_ID', 'my-bucket', $job)->json('result.status');
     * ```
     *
     * @link https://developers.cloudflare.com/r2/api/
     *
     * @param string $accountId Account Identifier.
     * @param string $bucketName Bucket Name.
     * @param string $jobId Job identifier, as returned when the operation was submitted.
     * @param string|null $jurisdiction Jurisdiction where objects in this bucket are guaranteed to be stored.
     *
     * @return ResponseInterface Get bucket job response
     */
    public function get(string $accountId, string $bucketName, string $jobId, ?string $jurisdiction = null): ResponseInterface
    {
        return $this->getHttpClient()->get("/accounts/{$accountId}/r2/buckets/{$bucketName}/jobs/{$jobId}", null, $this->jurisdictionHeader($jurisdiction));
    }
}
