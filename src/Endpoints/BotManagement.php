<?php

namespace Cloudflare\Endpoints;

use Cloudflare\Contracts\ResponseInterface;

class BotManagement extends AbstractEndpoint
{
    /**
     * Get the current Bot Management configuration for a zone.
     *
     * @link https://developers.cloudflare.com/api/operations/zone-bot-management-get-config
     *
     * @param string $zoneId Zone Identifier.
     *
     * @return ResponseInterface Get Zone Bot Management Config response
     */
    public function get(string $zoneId): ResponseInterface
    {
        return $this->getHttpClient()->get("/zones/{$zoneId}/bot_management");
    }

    /**
     * Update the Bot Management configuration for a zone.
     *
     * @link https://developers.cloudflare.com/api/operations/zone-bot-management-update-config
     *
     * @param string $zoneId Zone Identifier.
     * @param array $values Values to set on the Bot Management config, e.g. `fight_mode`, `enable_js`, `sbfm_definitely_automated`.
     *
     * @return ResponseInterface Update Zone Bot Management Config response
     */
    public function update(string $zoneId, array $values): ResponseInterface
    {
        return $this->getHttpClient()->put("/zones/{$zoneId}/bot_management", $values);
    }
}
