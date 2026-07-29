# Metrics

> Metrics endpoint reference.

## List

Get storage metrics for an account's R2 buckets.

<params-table :params="[{"name":"accountId","type":"string","required":true,"description":"Account Identifier."},{"name":"params","type":"array","required":false,"description":"Query Parameters.","default":"[]"}]">



</params-table>

```php [php]
$response = $client->r2()->metrics()->list('ACCOUNT_ID', []);
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/operations/r2-get-metrics">

View this operation on the Cloudflare API Reference

</callout>
