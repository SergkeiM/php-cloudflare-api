# Subdomain

> Subdomain endpoint reference.

## Get

Returns a Workers subdomain for an account.

<params-table :params="[{"name":"accountId","type":"string","required":true,"description":"Account identifier."}]">



</params-table>

```php [php]
$response = $client->workers()->subdomain()->get('ACCOUNT_ID');
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/operations/worker-subdomain-get-subdomain">

View this operation on the Cloudflare API Reference

</callout>

## Create

Creates a Workers subdomain for an account.

<params-table :params="[{"name":"accountId","type":"string","required":true,"description":"Account identifier."},{"name":"subdomain","type":"string","required":true,"description":"Subdomain."}]">



</params-table>

```php [php]
$response = $client->workers()->subdomain()->create('ACCOUNT_ID', 'SUBDOMAIN');
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/operations/worker-subdomain-create-subdomain">

View this operation on the Cloudflare API Reference

</callout>
