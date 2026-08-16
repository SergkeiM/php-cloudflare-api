<?php

namespace Cloudflare\Configurations\Rules;

class ConfigRule extends Rule
{
    /**
     * The action to perform when the rule matches. (set_config)
     * @var string
     */
    protected string $action = 'set_config';

    /**
     * Change one or more zone settings for a matching request.
     *
     * Cloudflare accepts a wide and growing set here — `ssl`, `bic`,
     * `automatic_https_rewrites`, `autominify`, `disable_apps`, `hotlink_protection`,
     * `mirage`, `polish`, `rocket_loader`, `security_level` and more — so the
     * settings are passed through as given.
     *
     * ```php
     * new ConfigRule(['ssl' => 'full', 'automatic_https_rewrites' => true]);
     * ```
     *
     * @param array $settings Zone settings to apply to the matching request.
     */
    public function __construct(
        private array $settings = []
    ) {
    }

    /**
     * The parameters configuring the rule's action.
     * @return ?array
     */
    protected function getActionParameters(): ?array
    {
        return $this->settings;
    }
}
