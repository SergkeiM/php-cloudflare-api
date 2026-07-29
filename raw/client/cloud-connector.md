# Cloud Connector

> Cloud Connector endpoint reference.

## Get

<params-table :params="[{"name":"zoneId","type":"string","required":true,"description":"Zone Identifier."}]">



</params-table>

```php [php]
$response = $client->cloudConnector()->get('ZONE_ID');
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/operations/zone-cloud-connector-rules">

View this operation on the Cloudflare API Reference

</callout>

## Update

<params-table :params="[{"name":"zoneId","type":"string","required":true,"description":"Zone Identifier."},{"name":"values","type":"array","required":true,"description":"List of Cloud Connector rules."}]">



</params-table>

```php [php]
$response = $client->cloudConnector()->update('ZONE_ID', []);
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/operations/zone-cloud-conenctor-rules-put">

View this operation on the Cloudflare API Reference

</callout>
