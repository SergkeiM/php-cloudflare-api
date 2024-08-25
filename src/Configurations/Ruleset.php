<?php

namespace Cloudflare\Configurations;

use Cloudflare\Contracts\Configuration;
use Cloudflare\Exceptions\BadMethodCallException;
use Cloudflare\Configurations\Rules\Rule;

/**
 * @method void managed() Set the kind to 'managed'
 * @method void custom() Set the kind to 'custom'
 * @method void root() Set the kind to 'root'
 * @method void zone() Set the kind to 'zone'
 *
 * @method void ddosL4() Set the phase to 'ddos_l4'
 * @method void ddosL7() Set the phase to 'ddos_l7'
 * @method void configSettings() Set the phase to 'http_config_settings'
 * @method void customErrors() Set the phase to 'http_custom_errors'
 * @method void logCustomFields() Set the phase to 'http_log_custom_fields'
 * @method void rateLimit() Set the phase to 'http_ratelimit'
 * @method void requestCacheSettings() Set the phase to 'http_request_cache_settings'
 * @method void requestDynamicRedirect() Set the phase to 'http_request_dynamic_redirect'
 * @method void requestFirewallCustom() Set the phase to 'http_request_firewall_custom'
 * @method void requestFirewallManaged() Set the phase to 'http_request_firewall_managed'
 * @method void requestLateTransform() Set the phase to 'http_request_late_transform'
 * @method void requestOrigin() Set the phase to 'http_request_origin'
 * @method void requestRedirect() Set the phase to 'http_request_redirect'
 * @method void requestSanitize() Set the phase to 'http_request_sanitize'
 * @method void requestSbfm() Set the phase to 'http_request_sbfm'
 * @method void requestSelectConfiguration() Set the phase to 'http_request_select_configuration'
 * @method void requestTransform() Set the phase to 'http_request_transform'
 * @method void responseCompression() Set the phase to 'http_response_compression'
 * @method void responseFirewallManaged() Set the phase to 'http_response_firewall_managed'
 * @method void responseHeadersTransform() Set the phase to 'http_response_headers_transform'
 * @method void magicTransit() Set the phase to 'magic_transit'
 * @method void magicTransitIdsManaged() Set the phase to 'magic_transit_ids_managed'
 * @method void magicTransitManaged() Set the phase to 'magic_transit_managed'
 */

class Ruleset implements Configuration
{
    /**
     * The kind of the ruleset.
     * @var string
     */
    private string $kind;

    /**
     * The phase of the ruleset.
     * @var string
     */
    private string $phase;

    /**
     * An array of rules.
     * @var \Cloudflare\Configurations\Rules\Rule[]
     */
    private array $rules = [];

    /**
     * An informative description of the ruleset.
     * @var string
     */
    private string $description;

    private $kinds = [
        'managed' => 'managed',
        'custom' => 'custom',
        'root' => 'root',
        'zone' => 'zone',
    ];

    private $phases = [
        'ddosL4' => 'ddos_l4',
        'ddosL7' => 'ddos_l7',
        'configSettings' => 'http_config_settings',
        'customErrors' => 'http_custom_errors',
        'logCustomFields' => 'http_log_custom_fields',
        'rateLimit' => 'http_ratelimit',
        'requestCacheSettings' => 'http_request_cache_settings',
        'requestDynamicRedirect' => 'http_request_dynamic_redirect',
        'requestFirewallCustom' => 'http_request_firewall_custom',
        'requestFirewallManaged' => 'http_request_firewall_managed',
        'requestLateTransform' => 'http_request_late_transform',
        'requestOrigin' => 'http_request_origin',
        'requestRedirect' => 'http_request_redirect',
        'requestSanitize' => 'http_request_sanitize',
        'requestSbfm' => 'http_request_sbfm',
        'requestSelectConfiguration' => 'http_request_select_configuration',
        'requestTransform' => 'http_request_transform',
        'responseCompression' => 'http_response_compression',
        'responseFirewallManaged' => 'http_response_firewall_managed',
        'responseHeadersTransform' => 'http_response_headers_transform',
        'transit' => 'magic_transit',
        'transitIdsManaged' => 'magic_transit_ids_managed',
        'transitManaged' => 'magic_transit_managed',
    ];

    /**
     * @param string $name The human-readable name of the ruleset.
     */
    public function __construct(
        private string $name
    ) {

    }

    /**
     * Set the name of the ruleset.
     * @param string $name
     * @return \Cloudflare\Configurations\Ruleset
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Set an informative description of the ruleset.
     * @param string $description
     * @return \Cloudflare\Configurations\Ruleset
     */
    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Add a new rule
     * @param \Cloudflare\Configurations\Rules\Rule $rule
     * @return \Cloudflare\Configurations\Ruleset
     */
    public function addRule(Rule $rule): self
    {
        $this->rules[] = $rule;

        return $this;
    }

    public function toArray(): array
    {
        $options = [
            'name' =>  $this->name,
            'kind' =>  $this->kind,
            'phase' =>  $this->phase,
            'rules' =>  array_map(fn (Rule $rule) => $rule->toArray(), $this->rules)
        ];

        if(!is_null($this->description)) {
            $options['description'] = $this->description;
        }

        return $options;
    }

    public function __call($name, $arguments)
    {
        if (array_key_exists($name, $this->phases)) {
            $this->phase = $this->phases[$name];
        } elseif (array_key_exists($name, $this->kinds)) {
            $this->kind = $this->kinds[$name];
        } else {
            throw new BadMethodCallException(sprintf('Undefined method called: "%s"', $name));
        }
    }
}
