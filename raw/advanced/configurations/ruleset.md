# Ruleset

> A fluent configuration helper for building Account/Zone Ruleset payloads.

## Usage

Cloudflare API provides extensive configuration for Account/Zone Ruleset, this helper aims to simplify it. `kind` and `phase` are set through magic methods rather than raw strings — `managed()`/`custom()`/`root()`/`zone()` for kind, and one method per phase (e.g. `configSettings()` for `http_config_settings`, `requestFirewallCustom()` for `http_request_firewall_custom`, `rateLimit()` for `http_ratelimit`) — so your editor can autocomplete valid values instead of you having to look up the exact phase string.

Rulesets are scoped to an account or a zone, so `create()` takes whichever identifier applies — named arguments keep that readable. The rules themselves are covered in [Rules](/advanced/configurations/rules), and `create()` also accepts a plain array if you would rather build the payload yourself.

```php [php]
use Cloudflare\Configurations\Rules\BlockRule;
use Cloudflare\Configurations\Ruleset;

$ruleset = (new Ruleset('The human-readable name of the ruleset.'))
    ->managed() //Set Ruleset kind to 'managed'
    ->configSettings() //Set Ruleset phase to 'http_config_settings'
    ->setDescription('An informative description of the ruleset.')
    ->addRule(new BlockRule('{"error": "blocked"}'));

$response = $client->rulesets()->create(zoneId: 'zone_id', values: $ruleset);
```
