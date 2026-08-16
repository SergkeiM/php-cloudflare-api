# UA Rules

> User Agent Blocking rules: match requests by their `User-Agent` header and act on them, per zone.

User Agent Blocking rules: match requests by their `User-Agent` header and
act on them, per zone.

## List

Fetch User Agent Blocking rules in a zone.

<params-table :params="[{"name":"zoneId","type":"string","required":true,"description":"Zone Identifier."},{"name":"params","type":"array","required":false,"description":"Query Parameters: `description`, `user_agent`, `paused`, `page` and `per_page`.","default":"[]"}]">



</params-table>

```php [php]
$response = $client->firewall()->uaRules()->list('ZONE_ID', []);
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/resources/firewall/subresources/ua_rules/methods/list/">

View this operation on the Cloudflare API Reference

</callout>

## Create

Create a new User Agent Blocking rule in a zone.

```php
$client->firewall()->uaRules()->create('ZONE_ID', [
    'mode' => 'block',
    'configuration' => ['target' => 'ua', 'value' => 'BadCrawler/1.0'],
    'description' => 'Block a misbehaving crawler',
]);
```

<params-table :params="[{"name":"zoneId","type":"string","required":true,"description":"Zone Identifier."},{"name":"values","type":"array","required":true,"description":"`mode`, one of `block`, `challenge`, `whitelist`, `js_challenge` or `managed_challenge`, and `configuration` with its `target` and `value`. `description` and `paused` are optional."}]">



</params-table>

```php [php]
$response = $client->firewall()->uaRules()->create('ZONE_ID', []);
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/resources/firewall/subresources/ua_rules/methods/create/">

View this operation on the Cloudflare API Reference

</callout>

## Get

Fetch the details of a User Agent Blocking rule.

<params-table :params="[{"name":"zoneId","type":"string","required":true,"description":"Zone Identifier."},{"name":"ruleId","type":"string","required":true,"description":"User Agent Blocking rule Identifier."}]">



</params-table>

```php [php]
$response = $client->firewall()->uaRules()->get('ZONE_ID', 'RULE_ID');
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/resources/firewall/subresources/ua_rules/methods/get/">

View this operation on the Cloudflare API Reference

</callout>

## Update

Update an existing User Agent Blocking rule, overwriting the full configuration.

Cloudflare wants the rule's `id` in the body as well as in the path, so
it is filled in from `$ruleId` unless `$values` carries one already.

<params-table :params="[{"name":"zoneId","type":"string","required":true,"description":"Zone Identifier."},{"name":"ruleId","type":"string","required":true,"description":"User Agent Blocking rule Identifier."},{"name":"values","type":"array","required":true,"description":"`mode` and `configuration` are required, with `description` and `paused` optional."}]">



</params-table>

```php [php]
$response = $client->firewall()->uaRules()->update('ZONE_ID', 'RULE_ID', []);
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/resources/firewall/subresources/ua_rules/methods/update/">

View this operation on the Cloudflare API Reference

</callout>

## Delete

Delete an existing User Agent Blocking rule.

<params-table :params="[{"name":"zoneId","type":"string","required":true,"description":"Zone Identifier."},{"name":"ruleId","type":"string","required":true,"description":"User Agent Blocking rule Identifier."}]">



</params-table>

```php [php]
$response = $client->firewall()->uaRules()->delete('ZONE_ID', 'RULE_ID');
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/resources/firewall/subresources/ua_rules/methods/delete/">

View this operation on the Cloudflare API Reference

</callout>
