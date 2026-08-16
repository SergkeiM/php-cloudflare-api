# Regions

> Regions endpoint reference.

## List

List Load Balancer region mappings for an account.

<params-table :params="[{"name":"accountId","type":"string","required":true,"description":"Account Identifier."},{"name":"params","type":"array","required":false,"description":"Query Parameters: `subdivision_code`, `subdivision_code_a2` and `country_code_a2`.","default":"[]"}]">



</params-table>

```php [php]
$response = $client->loadBalancers()->regions()->list('ACCOUNT_ID', []);
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/resources/load_balancers/subresources/regions/methods/list/">

View this operation on the Cloudflare API Reference

</callout>

## Get

Get a single Load Balancer region mapping for an account.

<params-table :params="[{"name":"accountId","type":"string","required":true,"description":"Account Identifier."},{"name":"regionId","type":"string","required":true,"description":"Region Identifier."}]">



</params-table>

```php [php]
$response = $client->loadBalancers()->regions()->get('ACCOUNT_ID', 'REGION_ID');
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/resources/load_balancers/subresources/regions/methods/get/">

View this operation on the Cloudflare API Reference

</callout>
