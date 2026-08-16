# Searches

> Searches endpoint reference.

## List

Search load balancing resources (Load Balancers, Pools, Monitors) by name.

<params-table :params="[{"name":"accountId","type":"string","required":true,"description":"Account Identifier."},{"name":"params","type":"array","required":false,"description":"Query Parameters, e.g. `query`, `references`, `page`, `per_page`.","default":"[]"}]">



</params-table>

```php [php]
$response = $client->loadBalancers()->searches()->list('ACCOUNT_ID', []);
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/resources/load_balancers/subresources/searches/methods/list/">

View this operation on the Cloudflare API Reference

</callout>
