<?php

namespace Cloudflare\Configurations\Rules;

class SetCacheSettingsRule extends Rule
{
    /**
     * The action to perform when the rule matches. (set_cache_settings)
     * @var string
     */
    protected string $action = 'set_cache_settings';

    protected function getActionParameters(): ?array
    {

    }
}
