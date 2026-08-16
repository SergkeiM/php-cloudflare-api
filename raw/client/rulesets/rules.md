# Rules

> Rules endpoint reference.

## Create

Adds a new rule to a ruleset.

<params-table :params="[{"name":"accountId","type":"string|null","required":true,"description":"Account Identifier. Provide exactly one of $accountId or $zoneId."},{"name":"zoneId","type":"string|null","required":true,"description":"Zone Identifier. Provide exactly one of $accountId or $zoneId."},{"name":"rulesetId","type":"string","required":true,"description":"Ruleset Identifier."},{"name":"values","type":"Rule|array","required":true,"configuration":"/advanced/configurations/rules","description":"A rule object."}]">



</params-table>

```php [php]
$response = $client->rulesets()->rules()->create('ACCOUNT_ID', 'ZONE_ID', 'RULESET_ID', $values);
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/resources/rulesets/subresources/rules/methods/create/">

View this operation on the Cloudflare API Reference

</callout>

## Edit

Updates an existing rule in a ruleset, creating a new version of the ruleset.

<params-table :params="[{"name":"accountId","type":"string|null","required":true,"description":"Account Identifier. Provide exactly one of $accountId or $zoneId."},{"name":"zoneId","type":"string|null","required":true,"description":"Zone Identifier. Provide exactly one of $accountId or $zoneId."},{"name":"rulesetId","type":"string","required":true,"description":"Ruleset Identifier."},{"name":"ruleId","type":"string","required":true,"description":"Rule Identifier."},{"name":"values","type":"Rule|array","required":true,"configuration":"/advanced/configurations/rules","description":"A rule object."}]">



</params-table>

```php [php]
$response = $client->rulesets()->rules()->edit('ACCOUNT_ID', 'ZONE_ID', 'RULESET_ID', 'RULE_ID', $values);
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/resources/rulesets/subresources/rules/methods/edit/">

View this operation on the Cloudflare API Reference

</callout>

## Delete

Deletes an existing rule from a ruleset, creating a new version of the ruleset.

<params-table :params="[{"name":"accountId","type":"string|null","required":true,"description":"Account Identifier. Provide exactly one of $accountId or $zoneId."},{"name":"zoneId","type":"string|null","required":true,"description":"Zone Identifier. Provide exactly one of $accountId or $zoneId."},{"name":"rulesetId","type":"string","required":true,"description":"Ruleset Identifier."},{"name":"ruleId","type":"string","required":true,"description":"Rule Identifier."}]">



</params-table>

```php [php]
$response = $client->rulesets()->rules()->delete('ACCOUNT_ID', 'ZONE_ID', 'RULESET_ID', 'RULE_ID');
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/resources/rulesets/subresources/rules/methods/delete/">

View this operation on the Cloudflare API Reference

</callout>
