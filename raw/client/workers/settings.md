# Settings

> Settings endpoint reference.

## Get

Fetches Worker account settings for an account.

<params-table :params="[{"name":"accountId","type":"string","required":true,"description":"Account identifier."}]">



</params-table>

```php [php]
$response = $client->workers()->settings()->get('ACCOUNT_ID');
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/resources/workers/subresources/account_settings/methods/get/">

View this operation on the Cloudflare API Reference

</callout>

## Update

Create Worker Account Settings

<params-table :params="[{"name":"accountId","type":"string","required":true,"description":"Account identifier."},{"name":"values","type":"array","required":true,"description":"`default_usage_model` and `green_compute`."}]">



</params-table>

```php [php]
$response = $client->workers()->settings()->update('ACCOUNT_ID', []);
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/resources/workers/subresources/account_settings/methods/update/">

View this operation on the Cloudflare API Reference

</callout>
