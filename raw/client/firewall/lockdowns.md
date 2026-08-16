# Lockdowns

> Lockdowns endpoint reference.

## List

Fetches Zone Lockdown rules. You can filter the results using several optional parameters.

<params-table :params="[{"name":"zoneId","type":"string","required":true,"description":"Zone Identifier."},{"name":"params","type":"array","required":false,"description":"Query Parameters","default":"[]"}]">



</params-table>

```php [php]
$response = $client->firewall()->lockdowns()->list('ZONE_ID', []);
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/resources/firewall/subresources/lockdowns/methods/list/">

View this operation on the Cloudflare API Reference

</callout>

## Create

Creates a new Zone Lockdown rule.

<params-table :params="[{"name":"zoneId","type":"string","required":true,"description":"Zone Identifier."},{"name":"values","type":"array","required":true,"description":"`urls` and `configurations` are required. Each configuration is `['target' => …, 'value' => …]`, where the target is `ip`, `ip_range`, `asn` or `country`. `description`, `priority` and `paused` are optional."}]">



</params-table>

```php [php]
$response = $client->firewall()->lockdowns()->create('ZONE_ID', []);
```

::callout{icon="i-simple-icons-cloudflare" to="[https://developers.cloudflare.com/api/resources/firewall/subresources/lockdowns/methods/create/](https://developers.cloudflare.com/api/resources/firewall/subresources/lockdowns/methods/create/) ```php
$client->firewall()->lockdowns()->create('ZONE_ID', <span>

'urls' => <span>

'example.com/admin*'

</span>

,
'configurations' => [
<span>

'target' => 'ip', 'value' => '198.51.100.4'

</span>

,
<span>

'target' => 'country', 'value' => 'US'

</span>

,
],
'description' => 'Admin area',

</span>

);

```"}
View this operation on the Cloudflare API Reference
::

## Get

Fetches the details of a Zone Lockdown rule.

::params-table
---
params:
  - name: "zoneId"
    type: "string"
    required: true
    description: "Zone Identifier."
  - name: "lockdownId"
    type: "string"
    required: true
    description: "Lockdown identifier ."
---
::

```php [php]
$response = $client->firewall()->lockdowns()->get('ZONE_ID', 'LOCKDOWN_ID');
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/resources/firewall/subresources/lockdowns/methods/get/">

View this operation on the Cloudflare API Reference

</callout>

## Update

Updates an existing Zone Lockdown rule.

<params-table :params="[{"name":"zoneId","type":"string","required":true,"description":"Zone Identifier."},{"name":"lockdownId","type":"string","required":true,"description":"Lockdown identifier"},{"name":"values","type":"array","required":true,"description":"`urls` and `configurations` are required, in the same shape as `create()`."}]">



</params-table>

```php [php]
$response = $client->firewall()->lockdowns()->update('ZONE_ID', 'LOCKDOWN_ID', []);
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/resources/firewall/subresources/lockdowns/methods/update/">

View this operation on the Cloudflare API Reference

</callout>

## Delete

Deletes an existing Zone Lockdown rule.

<params-table :params="[{"name":"zoneId","type":"string","required":true,"description":"Zone Identifier."},{"name":"lockdownId","type":"string","required":true,"description":"Lockdown identifier"}]">



</params-table>

```php [php]
$response = $client->firewall()->lockdowns()->delete('ZONE_ID', 'LOCKDOWN_ID');
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/resources/firewall/subresources/lockdowns/methods/delete/">

View this operation on the Cloudflare API Reference

</callout>
