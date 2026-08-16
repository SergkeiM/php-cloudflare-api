# Rulesets

> The Cloudflare Ruleset Engine allows you to create and deploy rules and rulesets in different Cloudflare products using the same basic syntax.

The Cloudflare Ruleset Engine allows you to create and deploy rules and
rulesets in different Cloudflare products using the same basic syntax.

## List

Fetches all rulesets.

<params-table :params="[{"name":"accountId","type":"string|null","required":false,"description":"Account Identifier. Provide exactly one of $accountId or $zoneId."},{"name":"zoneId","type":"string|null","required":false,"description":"Zone Identifier. Provide exactly one of $accountId or $zoneId."},{"name":"params","type":"array","required":false,"description":"Query Parameters: `cursor` and `per_page`.","default":"[]"}]">



</params-table>

```php [php]
$response = $client->rulesets()->list('ACCOUNT_ID', 'ZONE_ID', []);
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/resources/rulesets/methods/list/">

View this operation on the Cloudflare API Reference

</callout>

## Create

Creates a ruleset.

<params-table :params="[{"name":"accountId","type":"string|null","required":true,"description":"Account Identifier. Provide exactly one of $accountId or $zoneId."},{"name":"zoneId","type":"string|null","required":true,"description":"Zone Identifier. Provide exactly one of $accountId or $zoneId."},{"name":"values","type":"Ruleset|array","required":true,"configuration":"/advanced/configurations/ruleset","description":"A ruleset object."}]">



</params-table>

```php [php]
$response = $client->rulesets()->create('ACCOUNT_ID', 'ZONE_ID', $values);
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/resources/rulesets/methods/create/">

View this operation on the Cloudflare API Reference

</callout>

## Get

Fetches the latest version of a ruleset.

<params-table :params="[{"name":"accountId","type":"string|null","required":true,"description":"Account Identifier. Provide exactly one of $accountId or $zoneId."},{"name":"zoneId","type":"string|null","required":true,"description":"Zone Identifier. Provide exactly one of $accountId or $zoneId."},{"name":"rulesetId","type":"string","required":true,"description":"Ruleset Identifier."}]">



</params-table>

```php [php]
$response = $client->rulesets()->get('ACCOUNT_ID', 'ZONE_ID', 'RULESET_ID');
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/resources/rulesets/methods/get/">

View this operation on the Cloudflare API Reference

</callout>

## Update

Updates a ruleset, creating a new version of it.

The rules given replace the ones the ruleset holds, so send the full set,
not just the ones that changed.

<params-table :params="[{"name":"accountId","type":"string|null","required":true,"description":"Account Identifier. Provide exactly one of $accountId or $zoneId."},{"name":"zoneId","type":"string|null","required":true,"description":"Zone Identifier. Provide exactly one of $accountId or $zoneId."},{"name":"rulesetId","type":"string","required":true,"description":"Ruleset Identifier."},{"name":"values","type":"Ruleset|array","required":true,"configuration":"/advanced/configurations/ruleset","description":"A ruleset object."}]">



</params-table>

```php [php]
$response = $client->rulesets()->update('ACCOUNT_ID', 'ZONE_ID', 'RULESET_ID', $values);
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/resources/rulesets/methods/update/">

View this operation on the Cloudflare API Reference

</callout>

## Delete

Deletes all versions of an existing ruleset.

<params-table :params="[{"name":"accountId","type":"string|null","required":true,"description":"Account Identifier. Provide exactly one of $accountId or $zoneId."},{"name":"zoneId","type":"string|null","required":true,"description":"Zone Identifier. Provide exactly one of $accountId or $zoneId."},{"name":"rulesetId","type":"string","required":true,"description":"Ruleset Identifier."}]">



</params-table>

```php [php]
$response = $client->rulesets()->delete('ACCOUNT_ID', 'ZONE_ID', 'RULESET_ID');
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/resources/rulesets/methods/delete/">

View this operation on the Cloudflare API Reference

</callout>

## Related

- [Rules](/client/rulesets/rules)
- [Versions](/client/rulesets/versions)
- [Phases](/client/rulesets/phases)
