<?php

namespace Cloudflare\Endpoints\Workers;

use Cloudflare\Endpoints\AbstractEndpoint;
use Cloudflare\Contracts\CloudflareResponse;
use Cloudflare\Exceptions\BadMethodCallException;

class Environment extends AbstractEndpoint
{
    /**
     * Get script content from a worker with an environment
     *
     * @link https://developers.cloudflare.com/api/operations/worker-environment-get-script-content
     *
     * @param string $accountId Account identifier.
     * @param string $serviceName Name of Worker to bind to
     * @param string $environmentName Environment of the Worker.
     *
     * @return CloudflareResponse Get script content response
     */
    public function get(string $accountId, string $serviceName, string $environmentName): CloudflareResponse
    {
        return $this->getHttpClient()->get("/accounts/{$accountId}/workers/services/{$serviceName}/environments/{$environmentName}/content");
    }

    /**
     * Put script content from a worker with an environment
     *
     * @link https://developers.cloudflare.com/api/operations/worker-environment-put-script-content
     *
     * @param string $accountId Account identifier.
     * @param string $serviceName Name of Worker to bind to
     * @param string $environmentName Environment of the Worker.
     *
     * @return CloudflareResponse Get script content response
     */
    public function update(string $accountId, string $serviceName, string $environmentName): CloudflareResponse
    {
        // TODO

        throw new BadMethodCallException('Method update is not implemented yet');
    }

    /**
     * Get script settings from a worker with an environment
     *
     * @link https://developers.cloudflare.com/api/operations/worker-script-environment-get-settings
     *
     * @param string $accountId Account identifier.
     * @param string $serviceName Name of Worker to bind to
     * @param string $environmentName Environment of the Worker.
     *
     * @return CloudflareResponse Get script content response
     */
    public function getSettings(string $accountId, string $serviceName, string $environmentName): CloudflareResponse
    {
        return $this->getHttpClient()->get("/accounts/{$accountId}/workers/services/{$serviceName}/environments/{$environmentName}/settings");
    }

    /**
     * Patch script metadata, such as bindings
     *
     * @link https://developers.cloudflare.com/api/operations/worker-script-environment-patch-settings
     *
     * @param string $accountId Account identifier.
     * @param string $serviceName Name of Worker to bind to
     * @param string $environmentName Environment of the Worker.
     * @param array $values Settings values.
     *
     * @return CloudflareResponse Patch script settings
     */
    public function updateSettings(string $accountId, string $serviceName, string $environmentName, array $values): CloudflareResponse
    {
        return $this->getHttpClient()->patch("/accounts/{$accountId}/workers/services/{$serviceName}/environments/{$environmentName}/settings", $values);
    }
}
