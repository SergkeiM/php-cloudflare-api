# Page Rules

> Page Rules endpoint reference.

## Settings

Returns a list of settings (and their details) that Page Rules can apply to matching requests.

<params-table :params="[{"name":"zoneId","type":"string","required":true,"description":"Zone Identifier."}]">



</params-table>

```php [php]
$response = $client->pageRules()->settings('ZONE_ID');
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/operations/available-page-rules-settings-list-available-page-rules-settings">

View this operation on the Cloudflare API Reference

</callout>

## List

List Page Rules in a zone.

<params-table :params="[{"name":"zoneId","type":"string","required":true,"description":"Zone Identifier."},{"name":"params","type":"array","required":false,"description":"Query Parameters","default":"[]"}]">



</params-table>

```php [php]
$response = $client->pageRules()->list('ZONE_ID', []);
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/operations/page-rules-list-page-rules">

View this operation on the Cloudflare API Reference

</callout>

## Create

Create a Page Rule

<params-table :params="[{"name":"zoneId","type":"string","required":true,"description":"Zone Identifier."},{"name":"values","type":"mixed","required":true,"description":"Values to set on Page Rule."}]">



</params-table>

```php [php]
$response = $client->pageRules()->create('ZONE_ID', $values);
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/operations/page-rules-create-a-page-rule">

View this operation on the Cloudflare API Reference

</callout>

## Get

Fetches the details of a Page Rule.

<params-table :params="[{"name":"zoneId","type":"string","required":true,"description":"Zone Identifier."},{"name":"pageRuleId","type":"string","required":true,"description":"Page Rule Identifier."}]">



</params-table>

```php [php]
$response = $client->pageRules()->get('ZONE_ID', 'PAGE_RULE_ID');
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/operations/page-rules-get-a-page-rule">

View this operation on the Cloudflare API Reference

</callout>

## Edit

Updates one or more fields of an existing Page Rule.

<params-table :params="[{"name":"zoneId","type":"string","required":true,"description":"Zone Identifier."},{"name":"pageRuleId","type":"string","required":true,"description":"Page Rule Identifier."},{"name":"values","type":"mixed","required":true,"description":"Values to set on Page Rule."}]">



</params-table>

```php [php]
$response = $client->pageRules()->edit('ZONE_ID', 'PAGE_RULE_ID', $values);
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/operations/page-rules-edit-a-page-rule">

View this operation on the Cloudflare API Reference

</callout>

## Update

Replaces the configuration of an existing Page Rule. The configuration of the updated Page Rule will exactly match the data passed in the API request.

<params-table :params="[{"name":"zoneId","type":"string","required":true,"description":"Zone Identifier."},{"name":"pageRuleId","type":"string","required":true,"description":"Page Rule Identifier."},{"name":"values","type":"mixed","required":true,"description":"Values to set on Page Rule."}]">



</params-table>

```php [php]
$response = $client->pageRules()->update('ZONE_ID', 'PAGE_RULE_ID', $values);
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/operations/page-rules-update-a-page-rule">

View this operation on the Cloudflare API Reference

</callout>

## Delete

Delete a Page Rule

<params-table :params="[{"name":"zoneId","type":"string","required":true,"description":"Zone Identifier."},{"name":"pageRuleId","type":"string","required":true,"description":"Page Rule Identifier."}]">



</params-table>

```php [php]
$response = $client->pageRules()->delete('ZONE_ID', 'PAGE_RULE_ID');
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/operations/page-rules-delete-a-page-rule">

View this operation on the Cloudflare API Reference

</callout>
