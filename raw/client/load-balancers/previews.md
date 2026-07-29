# Previews

> Previews endpoint reference.

## Get

Get the result of a previously requested monitor or pool preview.

<params-table :params="[{"name":"accountId","type":"string","required":true,"description":"Account Identifier."},{"name":"previewId","type":"string","required":true,"description":"Preview Identifier."}]">



</params-table>

```php [php]
$response = $client->loadBalancers()->previews()->get('ACCOUNT_ID', 'PREVIEW_ID');
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/operations/account-load-balancer-monitors-preview-result">

View this operation on the Cloudflare API Reference

</callout>
