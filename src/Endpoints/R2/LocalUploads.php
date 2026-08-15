<?php

namespace Cloudflare\Endpoints\R2;

use Cloudflare\Endpoints\AbstractEndpoint;
use Cloudflare\Contracts\ResponseInterface;

/**
 * Local uploads for an R2 bucket.
 *
 * With local uploads on, an object is written to the region nearest the writer
 * first and replicated to the bucket's primary region afterwards, which trades
 * immediate consistency across regions for a faster write.
 *
 * @link https://developers.cloudflare.com/r2/buckets/data-location/
 */
class LocalUploads extends AbstractEndpoint
{
    /**
     * Get the local uploads configuration for a bucket.
     *
     * @link https://developers.cloudflare.com/r2/buckets/data-location/
     *
     * @param string $accountId Account Identifier.
     * @param string $bucketName Bucket Name.
     *
     * @return ResponseInterface Local uploads configuration response
     */
    public function get(string $accountId, string $bucketName): ResponseInterface
    {
        return $this->getHttpClient()->get("/accounts/{$accountId}/r2/buckets/{$bucketName}/local-uploads");
    }

    /**
     * Turn local uploads on or off for a bucket.
     *
     * @link https://developers.cloudflare.com/r2/buckets/data-location/
     *
     * @param string $accountId Account Identifier.
     * @param string $bucketName Bucket Name.
     * @param bool $enabled Whether to enable local uploads for this bucket.
     *
     * @return ResponseInterface Update local uploads configuration response
     */
    public function update(string $accountId, string $bucketName, bool $enabled): ResponseInterface
    {
        return $this->getHttpClient()->put("/accounts/{$accountId}/r2/buckets/{$bucketName}/local-uploads", [
            'enabled' => $enabled,
        ]);
    }
}
