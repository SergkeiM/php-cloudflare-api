<?php

namespace Cloudflare\Endpoints\Zones;

use Cloudflare\Endpoints\AbstractEndpoint;
use Cloudflare\Contracts\ResponseInterface;
use Cloudflare\Configurations\Rules\Rule;

class Rules extends AbstractEndpoint
{
    public function create(string $zoneId, string $rulesetId, array|Rule $values): ResponseInterface
    {
        if(is_array($values)) {
            //$this->requiredParams(['name', 'kind', 'phase', 'rules'], $values);
        } else {
            $values = $values->toArray();
        }

        return $this->getHttpClient()->post("/zones/{$zoneId}/rulesets/{$rulesetId}/rules", $values);
    }
}