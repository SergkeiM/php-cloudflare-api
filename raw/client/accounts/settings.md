# Settings

> Account-wide settings, as opposed to the per-zone toggles under `$client->zones()->settings()`.

Account-wide settings, as opposed to the per-zone toggles under
`$client->zones()->settings()`.

## Transformations

List the Image Resizing configuration of every zone in an account.

The account-wide view of the per-zone `image_resizing` setting, which
saves reading it zone by zone through
`$client->zones()->settings()->get()`.

<params-table :params="[{"name":"accountId","type":"string","required":true,"description":"Account Identifier."}]">



</params-table>

```php [php]
$response = $client->accounts()->settings()->transformations('ACCOUNT_ID');
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/resources/images/">

View this operation on the Cloudflare API Reference

</callout>

## Unique Transformations Billing

Get the Unique Transformations billing setting for an account.

<params-table :params="[{"name":"accountId","type":"string","required":true,"description":"Account Identifier."}]">



</params-table>

```php [php]
$response = $client->accounts()->settings()->uniqueTransformationsBilling('ACCOUNT_ID');
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/resources/images/">

View this operation on the Cloudflare API Reference

</callout>

## Update Unique Transformations Billing

Enable Unique Transformations billing for an account.

Directs billing data to the Transformations pipeline. Cloudflare accepts
only `on` here: once enabled, the setting cannot be turned back off.

<params-table :params="[{"name":"accountId","type":"string","required":true,"description":"Account Identifier."},{"name":"values","type":"array","required":false,"description":"Setting value, `['value' => 'on']`.","default":"array ( 'value' => 'on', )"}]">



</params-table>

```php [php]
$response = $client->accounts()->settings()->updateUniqueTransformationsBilling('ACCOUNT_ID', []);
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/resources/images/">

View this operation on the Cloudflare API Reference

</callout>
