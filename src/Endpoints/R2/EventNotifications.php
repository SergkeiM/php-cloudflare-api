<?php

namespace Cloudflare\Endpoints\R2;

use Cloudflare\Endpoints\AbstractEndpoint;
use Cloudflare\Contracts\ResponseInterface;

class EventNotifications extends AbstractEndpoint
{
    /**
     * Read the event notification configuration for a bucket, listing rules for all configured queues.
     *
     * @link https://developers.cloudflare.com/api/resources/r2/subresources/buckets/subresources/event_notifications/methods/list/
     *
     * @param string $accountId Account Identifier.
     * @param string $bucketName Bucket Name.
     * @param string|null $jurisdiction Jurisdiction where objects in this bucket are guaranteed to be stored.
     *
     * @return ResponseInterface Read configuration response
     */
    public function list(string $accountId, string $bucketName, ?string $jurisdiction = null): ResponseInterface
    {
        return $this->getHttpClient()->get("/accounts/{$accountId}/event_notifications/r2/{$bucketName}/configuration", null, $this->jurisdictionHeader($jurisdiction));
    }

    /**
     * Get the event notification configuration for a bucket and a specific queue.
     *
     * @link https://developers.cloudflare.com/api/resources/r2/subresources/buckets/subresources/event_notifications/methods/get/
     *
     * @param string $accountId Account Identifier.
     * @param string $bucketName Bucket Name.
     * @param string $queueId Queue Identifier.
     * @param string|null $jurisdiction Jurisdiction where objects in this bucket are guaranteed to be stored.
     *
     * @return ResponseInterface Queue configuration response
     */
    public function get(string $accountId, string $bucketName, string $queueId, ?string $jurisdiction = null): ResponseInterface
    {
        return $this->getHttpClient()->get("/accounts/{$accountId}/event_notifications/r2/{$bucketName}/configuration/queues/{$queueId}", null, $this->jurisdictionHeader($jurisdiction));
    }

    /**
     * Create or update the event notification configuration for a bucket and a specific queue.
     *
     * @link https://developers.cloudflare.com/api/resources/r2/subresources/buckets/subresources/event_notifications/methods/update/
     *
     * @param string $accountId Account Identifier.
     * @param string $bucketName Bucket Name.
     * @param string $queueId Queue Identifier.
     * @param array $values Values to set, e.g. `rules`.
     * @param string|null $jurisdiction Jurisdiction where objects in this bucket are guaranteed to be stored.
     *
     * @return ResponseInterface Create configuration response
     */
    public function update(string $accountId, string $bucketName, string $queueId, array $values, ?string $jurisdiction = null): ResponseInterface
    {
        return $this->getHttpClient()->put("/accounts/{$accountId}/event_notifications/r2/{$bucketName}/configuration/queues/{$queueId}", $values, $this->jurisdictionHeader($jurisdiction));
    }

    /**
     * Delete the event notification configuration for a bucket and a specific queue.
     *
     * @link https://developers.cloudflare.com/api/resources/r2/subresources/buckets/subresources/event_notifications/methods/delete/
     *
     * @param string $accountId Account Identifier.
     * @param string $bucketName Bucket Name.
     * @param string $queueId Queue Identifier.
     * @param string|null $jurisdiction Jurisdiction where objects in this bucket are guaranteed to be stored.
     *
     * @return ResponseInterface Delete configuration response
     */
    public function delete(string $accountId, string $bucketName, string $queueId, ?string $jurisdiction = null): ResponseInterface
    {
        return $this->getHttpClient()->delete("/accounts/{$accountId}/event_notifications/r2/{$bucketName}/configuration/queues/{$queueId}", [], $this->jurisdictionHeader($jurisdiction));
    }
}
