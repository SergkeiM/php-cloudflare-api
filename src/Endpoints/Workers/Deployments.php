<?php

namespace Cloudflare\Endpoints\Workers;

use Cloudflare\Endpoints\AbstractEndpoint;
use Cloudflare\Contracts\CloudflareResponse;
use Cloudflare\Configurations\Workers\Deployment;

class Deployments extends AbstractEndpoint
{
    /**
      * List of Worker Deployments. The first deployment in the list is the latest deployment actively serving traffic.
      *
      * @link https://developers.cloudflare.com/api/operations/worker-deployments-list-deployments
      *
      * @param string $accountId Account identifier.
      * @param string $scriptMame Name of the script, used in URLs and route configuration.
      *
      * @return \Cloudflare\Contracts\CloudflareResponse List Deployments response
      */
    public function get(string $accountId, string $scriptMame): CloudflareResponse
    {
        return $this->getHttpClient()->get("/accounts/{$accountId}/workers/scripts/${scriptMame}/deployments");
    }

    /**
     * Deployments configure how [Worker Versions](https://developers.cloudflare.com/api/operations/worker-versions-list-versions) are deployed to traffic. A deployment can consist of one or two versions of a Worker.
     *
     * @link https://developers.cloudflare.com/api/operations/worker-cron-trigger-update-cron-triggers
     *
     * @param string $accountId Account identifier.
     * @param string $scriptMame Name of the script, used in URLs and route configuration.
     * @param array|\Cloudflare\Configurations\Workers\Deployment $values Dployment config.
     * @param bool $force If set to true, the deployment will be created even if normally blocked by something such rolling back to an older version when a secret has changed.
     *
     * @return \Cloudflare\Contracts\CloudflareResponse Create Deployment response
     */
    public function create(
        string $accountId,
        string $scriptMame,
        array|Deployment $values,
        bool $force = false
    ): CloudflareResponse {

        if(is_array($values)) {
            $this->requiredParams(['strategy', 'versions'], $values);
        } else {
            $values = $values->toArray();
        }

        $options = [];

        if($force) {
            $options = [
                'query' => [
                    'force' => $force
                ]
            ];
        }

        return $this->getHttpClient()->post("/accounts/{$accountId}/workers/scripts/${scriptMame}/deployments", $values, $options);
    }
}
