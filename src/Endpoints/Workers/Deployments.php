<?php

namespace SergkeiM\CloudFlare\Endpoints\Workers;

use SergkeiM\CloudFlare\Endpoints\AbstractEndpoint;
use SergkeiM\CloudFlare\Contracts\CloudFlareResponse;

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
      * @return CloudFlareResponse List Deployments response
      */
    public function get(string $accountId, string $scriptMame): CloudFlareResponse
    {
        return $this->getHttpClient()->get("/accounts/{$accountId}/workers/scripts/${scriptMame}/deployments");
    }

    /**
     * Deployments configure how [Worker Versions](https://developers.cloudflare.com/api/operations/worker-versions-list-versions) are deployed to traffic. A deployment can consist of one or two versions of a Worker.
     *
     * @link https://developers.cloudflare.com/api/operations/worker-cron-trigger-update-cron-triggers
     *
     * @param string $accountId Account identifier.
     * @param string $scriptMame Name of the script.
     * @param array $values Name of the script.
     * @param boolean $force If set to true, the deployment will be created even if normally blocked by something such rolling back to an older version when a secret has changed.
     *
     * @return CloudFlareResponse Create Worker Account Settings response
     */
    public function create(string $accountId, string $scriptMame, array $values, bool $force = false): CloudFlareResponse
    {
        $this->requiredParams([
            'strategy',
            'versions'
        ], $values);

        return $this->getHttpClient()->post("/accounts/{$accountId}/workers/scripts/${scriptMame}/deployments", $values, [
            'query' => [
                'force' => $force
            ]
        ]);
    }
}
