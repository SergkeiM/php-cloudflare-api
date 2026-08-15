<?php

namespace Cloudflare\Endpoints;

use Cloudflare\Endpoints\R2\Buckets;
use Cloudflare\Endpoints\R2\Cors;
use Cloudflare\Endpoints\R2\Lifecycle;
use Cloudflare\Endpoints\R2\Lock;
use Cloudflare\Endpoints\R2\CustomDomains;
use Cloudflare\Endpoints\R2\ManagedDomain;
use Cloudflare\Endpoints\R2\Sippy;
use Cloudflare\Endpoints\R2\EventNotifications;
use Cloudflare\Endpoints\R2\Metrics;
use Cloudflare\Endpoints\R2\Objects;
use Cloudflare\Endpoints\R2\Jobs;
use Cloudflare\Endpoints\R2\LocalUploads;

class R2 extends AbstractEndpoint
{
    /**
     * R2 Buckets
     *
     * @return \Cloudflare\Endpoints\R2\Buckets
     */
    public function buckets(): Buckets
    {
        return new Buckets($this->getClient());
    }

    /**
     * R2 Bucket CORS
     *
     * @return \Cloudflare\Endpoints\R2\Cors
     */
    public function cors(): Cors
    {
        return new Cors($this->getClient());
    }

    /**
     * R2 Bucket Lifecycle
     *
     * @return \Cloudflare\Endpoints\R2\Lifecycle
     */
    public function lifecycle(): Lifecycle
    {
        return new Lifecycle($this->getClient());
    }

    /**
     * R2 Bucket Object Lock
     *
     * @return \Cloudflare\Endpoints\R2\Lock
     */
    public function lock(): Lock
    {
        return new Lock($this->getClient());
    }

    /**
     * R2 Bucket Custom Domains
     *
     * @return \Cloudflare\Endpoints\R2\CustomDomains
     */
    public function customDomains(): CustomDomains
    {
        return new CustomDomains($this->getClient());
    }

    /**
     * R2 Bucket Managed Domain
     *
     * @return \Cloudflare\Endpoints\R2\ManagedDomain
     */
    public function managedDomain(): ManagedDomain
    {
        return new ManagedDomain($this->getClient());
    }

    /**
     * R2 Bucket Sippy
     *
     * @return \Cloudflare\Endpoints\R2\Sippy
     */
    public function sippy(): Sippy
    {
        return new Sippy($this->getClient());
    }

    /**
     * R2 Bucket Event Notifications
     *
     * @return \Cloudflare\Endpoints\R2\EventNotifications
     */
    public function eventNotifications(): EventNotifications
    {
        return new EventNotifications($this->getClient());
    }

    /**
     * R2 Metrics
     *
     * @return \Cloudflare\Endpoints\R2\Metrics
     */
    public function metrics(): Metrics
    {
        return new Metrics($this->getClient());
    }

    /**
     * R2 Bucket Objects
     *
     * @return \Cloudflare\Endpoints\R2\Objects
     */
    public function objects(): Objects
    {
        return new Objects($this->getClient());
    }

    /**
     * R2 Bucket Background Jobs
     *
     * @return \Cloudflare\Endpoints\R2\Jobs
     */
    public function jobs(): Jobs
    {
        return new Jobs($this->getClient());
    }

    /**
     * R2 Bucket Local Uploads
     *
     * @return \Cloudflare\Endpoints\R2\LocalUploads
     */
    public function localUploads(): LocalUploads
    {
        return new LocalUploads($this->getClient());
    }
}
