# Phases

> Each phase of the Ruleset Engine runs one entry point ruleset, which is where your own rules for that phase live — `http_request_firewall_custom` for custom firewall rules, `http_request_transform` for URL rewrites, and so on.

Each phase of the Ruleset Engine runs one entry point ruleset, which is where
your own rules for that phase live — `http_request_firewall_custom` for custom
firewall rules, `http_request_transform` for URL rewrites, and so on.

## Get

Fetches the latest version of the entry point ruleset for a phase.

<params-table :params="[{"name":"accountId","type":"string|null","required":true,"description":"Account Identifier. Provide exactly one of $accountId or $zoneId."},{"name":"zoneId","type":"string|null","required":true,"description":"Zone Identifier. Provide exactly one of $accountId or $zoneId."},{"name":"phase","type":"string","required":true,"description":"The phase of the ruleset, e.g. `http_request_firewall_custom`."}]">



</params-table>

```php [php]
$response = $client->rulesets()->phases()->get('ACCOUNT_ID', 'ZONE_ID', 'PHASE');
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/resources/rulesets/subresources/phases/methods/get/">

View this operation on the Cloudflare API Reference

</callout>

## Update

Updates the entry point ruleset for a phase, creating it if the phase has
none yet.

The rules given replace the ones the entry point holds, so send the full
set, not just the ones that changed.

<params-table :params="[{"name":"accountId","type":"string|null","required":true,"description":"Account Identifier. Provide exactly one of $accountId or $zoneId."},{"name":"zoneId","type":"string|null","required":true,"description":"Zone Identifier. Provide exactly one of $accountId or $zoneId."},{"name":"phase","type":"string","required":true,"description":"The phase of the ruleset, e.g. `http_request_firewall_custom`."},{"name":"values","type":"Ruleset|array","required":true,"configuration":"/advanced/configurations/ruleset","description":"A ruleset object."}]">



</params-table>

```php [php]
$response = $client->rulesets()->phases()->update('ACCOUNT_ID', 'ZONE_ID', 'PHASE', $values);
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/resources/rulesets/subresources/phases/methods/update/">

View this operation on the Cloudflare API Reference

</callout>

## Versions

Fetches the versions of the entry point ruleset for a phase.

<params-table :params="[{"name":"accountId","type":"string|null","required":true,"description":"Account Identifier. Provide exactly one of $accountId or $zoneId."},{"name":"zoneId","type":"string|null","required":true,"description":"Zone Identifier. Provide exactly one of $accountId or $zoneId."},{"name":"phase","type":"string","required":true,"description":"The phase of the ruleset, e.g. `http_request_firewall_custom`."}]">



</params-table>

```php [php]
$response = $client->rulesets()->phases()->versions('ACCOUNT_ID', 'ZONE_ID', 'PHASE');
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/resources/rulesets/subresources/phases/subresources/versions/methods/list/">

View this operation on the Cloudflare API Reference

</callout>

## Version

Fetches a specific version of the entry point ruleset for a phase.

<params-table :params="[{"name":"accountId","type":"string|null","required":true,"description":"Account Identifier. Provide exactly one of $accountId or $zoneId."},{"name":"zoneId","type":"string|null","required":true,"description":"Zone Identifier. Provide exactly one of $accountId or $zoneId."},{"name":"phase","type":"string","required":true,"description":"The phase of the ruleset, e.g. `http_request_firewall_custom`."},{"name":"version","type":"string","required":true,"description":"Version of the ruleset."}]">



</params-table>

```php [php]
$response = $client->rulesets()->phases()->version('ACCOUNT_ID', 'ZONE_ID', 'PHASE', 'VERSION');
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/resources/rulesets/subresources/phases/subresources/versions/methods/get/">

View this operation on the Cloudflare API Reference

</callout>
