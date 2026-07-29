# Ruleset

> A fluent configuration helper for building Account/Zone Ruleset payloads.

## Usage

Cloudflare API provides extensive configuration for Account/Zone Ruleset, this helper aims to simplify it. `kind` and `phase` are set through magic methods rather than raw strings — `managed()`/`custom()`/`root()`/`zone()` for kind, and one method per phase (e.g. `configSettings()` for `http_config_settings`, `requestFirewallCustom()` for `http_request_firewall_custom`, `rateLimit()` for `http_ratelimit`) — so your editor can autocomplete valid values instead of you having to look up the exact phase string.

```php [php]
use Cloudflare\Configurations\Rules\BlockRule;
use Cloudflare\Configurations\Ruleset;

$ruleset = (new Ruleset('The human-readable name of the ruleset.'))
    ->managed() //Set Ruleset kind to 'managed'
    ->configSettings() //Set Ruleset phase to 'http_config_settings'
    ->setDescription('An informative description of the ruleset.')
    ->addRule(new BlockRule(['error' => 'blocked']));

$response = $client->rulesets()->create(null, 'zone_id', $ruleset);
```
