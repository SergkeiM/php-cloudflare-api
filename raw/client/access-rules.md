# Access Rules

> Access Rules endpoint reference.

## List

List, search, sort, and filter a zone's IP Access rules.

<params-table :params="[{"name":"zoneId","type":"string","required":true,"description":"Zone Identifier."},{"name":"params","type":"array","required":false,"description":"Query Parameters.","default":"[]"}]">



</params-table>

```php [php]
$response = $client->accessRules()->list('ZONE_ID', []);
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/operations/ip-access-rules-for-a-zone-list-ip-access-rules">

View this operation on the Cloudflare API Reference

</callout>

## Create

Create a new IP Access rule for a zone.

<params-table :params="[{"name":"zoneId","type":"string","required":true,"description":"Zone Identifier."},{"name":"values","type":"array","required":true,"description":"Values to set on the IP Access rule, e.g. `mode`, `configuration` (`target`, `value`), `notes`."}]">



</params-table>

```php [php]
$response = $client->accessRules()->create('ZONE_ID', []);
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/operations/ip-access-rules-for-a-zone-create-an-ip-access-rule">

View this operation on the Cloudflare API Reference

</callout>

## Edit

Apply changes to an existing IP Access rule for a zone, overwriting only the supplied properties.

<params-table :params="[{"name":"zoneId","type":"string","required":true,"description":"Zone Identifier."},{"name":"ruleId","type":"string","required":true,"description":"IP Access Rule Identifier."},{"name":"values","type":"array","required":true,"description":"Values to set on the IP Access rule, e.g. `mode`, `notes`."}]">



</params-table>

```php [php]
$response = $client->accessRules()->edit('ZONE_ID', 'RULE_ID', []);
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/operations/ip-access-rules-for-a-zone-update-an-ip-access-rule">

View this operation on the Cloudflare API Reference

</callout>

## Delete

Delete an IP Access rule for a zone.

<params-table :params="[{"name":"zoneId","type":"string","required":true,"description":"Zone Identifier."},{"name":"ruleId","type":"string","required":true,"description":"IP Access Rule Identifier."}]">



</params-table>

```php [php]
$response = $client->accessRules()->delete('ZONE_ID', 'RULE_ID');
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/operations/ip-access-rules-for-a-zone-delete-an-ip-access-rule">

View this operation on the Cloudflare API Reference

</callout>
