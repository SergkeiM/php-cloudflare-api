<?php

namespace Cloudflare\Endpoints\Workers;

use Cloudflare\Endpoints\AbstractEndpoint;
use Cloudflare\Contracts\ResponseInterface;

class Cron extends AbstractEndpoint
{
    /**
      * Get Cron Triggers
      *
      * @link https://developers.cloudflare.com/api/operations/worker-cron-trigger-get-cron-triggers
      *
      * @param string $accountId Account identifier.
      * @param string $scriptName Name of the script, used in URLs and route configuration.
      *
      * @return ResponseInterface Get Cron Triggers response
      */
    public function get(string $accountId, string $scriptName): ResponseInterface
    {
        return $this->getHttpClient()->get("/accounts/{$accountId}/workers/scripts/${scriptName}/schedules");
    }

    /**
     * Updates Cron Triggers for a Worker.
     *
     * @link https://developers.cloudflare.com/api/operations/worker-cron-trigger-update-cron-triggers
     *
     * @param string $accountId Account identifier.
     * @param string $scriptName Name of the script, used in URLs and route configuration.
     * @param array $schedules Values to set on Script schedules.
     *
     * @return ResponseInterface Create Worker Account Settings response
     */
    public function update(string $accountId, string $scriptName, array $schedules): ResponseInterface
    {
        $values = [];

        foreach ($schedules as $schedule) {
            $values[] = [
                'cron' => $schedule
            ];
        }

        return $this->getHttpClient()->put("/accounts/{$accountId}/workers/scripts/${scriptName}/schedules", $values);
    }
}
