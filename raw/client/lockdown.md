# Lockdown

> Lockdown endpoint reference.

## List

Fetches Zone Lockdown rules. You can filter the results using several optional parameters.

<params-table :params="[{"name":"zoneId","type":"string","required":true,"description":"Zone Identifier."},{"name":"params","type":"array","required":false,"description":"Query Parameters","default":"[]"}]">



</params-table>

```php [php]
$response = $client->lockdown()->list('ZONE_ID', []);
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/operations/zone-lockdown-list-zone-lockdown-rules">

View this operation on the Cloudflare API Reference

</callout>

## Create

Creates a new Zone Lockdown rule.

<params-table :params="[{"name":"zoneId","type":"string","required":true,"description":"Zone Identifier."},{"name":"value","type":"string","required":true,"description":"The IP address/range to match. You can only use prefix lengths /16 and /24. This address/range will be compared to the IP address of incoming requests."},{"name":"urls","type":"array","required":true,"description":"The URLs to include in the current WAF override. You can use wildcards. Each entered URL will be escaped before use, which means you can only use simple wildcard patterns."}]">



</params-table>

```php [php]
$response = $client->lockdown()->create('ZONE_ID', 'VALUE', []);
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/operations/zone-lockdown-create-a-zone-lockdown-rule">

View this operation on the Cloudflare API Reference

</callout>

## Get

Fetches the details of a Zone Lockdown rule.

<params-table :params="[{"name":"zoneId","type":"string","required":true,"description":"Zone Identifier."},{"name":"lockdownId","type":"string","required":true,"description":"Lockdown identifie"}]" :0="{"\"":null}">



</params-table>

```php [php]
$response = $client->lockdown()->get('ZONE_ID', 'LOCKDOWN_ID');
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/operations/zone-lockdown-get-a-zone-lockdown-rule">

View this operation on the Cloudflare API Reference

</callout>

## Update

Updates an existing Zone Lockdown rule.

<params-table :params="[{"name":"zoneId","type":"string","required":true,"description":"Zone Identifier."},{"name":"lockdownId","type":"string","required":true,"description":"Lockdown identifier"},{"name":"value","type":"string","required":true,"description":"The IP address/range to match. You can only use prefix lengths /16 and /24. This address/range will be compared to the IP address of incoming requests."},{"name":"urls","type":"array","required":true,"description":"The URLs to include in the current WAF override. You can use wildcards. Each entered URL will be escaped before use, which means you can only use simple wildcard patterns."}]">



</params-table>

```php [php]
$response = $client->lockdown()->update('ZONE_ID', 'LOCKDOWN_ID', 'VALUE', []);
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/operations/zone-lockdown-update-a-zone-lockdown-rule">

View this operation on the Cloudflare API Reference

</callout>

## Delete

Deletes an existing Zone Lockdown rule.

<params-table :params="[{"name":"zoneId","type":"string","required":true,"description":"Zone Identifier."},{"name":"lockdownId","type":"string","required":true,"description":"Lockdown identifier"}]">



</params-table>

```php [php]
$response = $client->lockdown()->delete('ZONE_ID', 'LOCKDOWN_ID');
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/operations/zone-lockdown-delete-a-zone-lockdown-rule">

View this operation on the Cloudflare API Reference

</callout>
