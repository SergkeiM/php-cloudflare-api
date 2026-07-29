# Rules

> Rules endpoint reference.

## Create

Adds a new rule to a ruleset.

<params-table :params="[{"name":"accountId","type":"string|null","required":true,"description":"Account Identifier. Provide exactly one of $accountId or $zoneId."},{"name":"zoneId","type":"string|null","required":true,"description":"Zone Identifier. Provide exactly one of $accountId or $zoneId."},{"name":"rulesetId","type":"string","required":true,"description":"Ruleset Identifier."},{"name":"values","type":"mixed","required":true,"description":"A rule object."}]">



</params-table>

```php [php]
$response = $client->rulesets()->rules()->create('ACCOUNT_ID', 'ZONE_ID', 'RULESET_ID', $values);
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/operations/updateZoneRuleset">

View this operation on the Cloudflare API Reference

</callout>
