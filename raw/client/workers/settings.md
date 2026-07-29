# Settings

> Settings endpoint reference.

## Get

Fetches Worker account settings for an account.

<params-table :params="[{"name":"accountId","type":"string","required":true,"description":"Account identifier."}]">



</params-table>

```php [php]
$response = $client->workers()->settings()->get('ACCOUNT_ID');
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/operations/worker-account-settings-fetch-worker-account-settings">

View this operation on the Cloudflare API Reference

</callout>

## Create

Create Worker Account Settings

<params-table :params="[{"name":"accountId","type":"string","required":true,"description":"Account identifier."},{"name":"usageModel","type":"string","required":true,"description":"Default usage model."},{"name":"greenCompute","type":"bool","required":true,"description":"Green compute."}]">



</params-table>

```php [php]
$response = $client->workers()->settings()->create('ACCOUNT_ID', 'USAGE_MODEL', true);
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/operations/worker-account-settings-create-worker-account-settings">

View this operation on the Cloudflare API Reference

</callout>
