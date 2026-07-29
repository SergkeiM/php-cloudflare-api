# Scripts

> Scripts endpoint reference.

## List

Fetch a list of uploaded workers.

<params-table :params="[{"name":"accountId","type":"string","required":true,"description":"Account identifier."}]">



</params-table>

```php [php]
$response = $client->workers()->scripts()->list('ACCOUNT_ID');
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/operations/worker-script-list-workers">

View this operation on the Cloudflare API Reference

</callout>

## Download

Fetch raw script content for your worker. Note this is the original script content, not JSON encoded.

<params-table :params="[{"name":"accountId","type":"string","required":true,"description":"Account identifier."},{"name":"scriptName","type":"string","required":true,"description":"Name of the script, used in URLs and route configuration."}]">



</params-table>

```php [php]
$response = $client->workers()->scripts()->download('ACCOUNT_ID', 'SCRIPT_NAME');
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/operations/worker-script-download-worker">

View this operation on the Cloudflare API Reference

</callout>

## Upload

Upload a worker module. You can find more about the multipart metadata on [Cloudflare Docs](https://developers.cloudflare.com/workers/configuration/multipart-upload-metadata/).

<params-table :params="[{"name":"accountId","type":"string","required":true,"description":"Account identifier."},{"name":"scriptName","type":"string","required":true,"description":"Name of the script, used in URLs and route configuration."}]">



</params-table>

```php [php]
$response = $client->workers()->scripts()->upload('ACCOUNT_ID', 'SCRIPT_NAME');
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/operations/worker-script-upload-worker-module">

View this operation on the Cloudflare API Reference

</callout>

## Update Content

Put script content without touching config or metadata

<params-table :params="[{"name":"accountId","type":"string","required":true,"description":"Account identifier."},{"name":"scriptName","type":"string","required":true,"description":"Name of the script, used in URLs and route configuration."}]">



</params-table>

```php [php]
$response = $client->workers()->scripts()->updateContent('ACCOUNT_ID', 'SCRIPT_NAME');
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/operations/worker-script-put-content">

View this operation on the Cloudflare API Reference

</callout>

## Get Content

Fetch script content only.

<params-table :params="[{"name":"accountId","type":"string","required":true,"description":"Account identifier."},{"name":"scriptName","type":"string","required":true,"description":"Name of the script, used in URLs and route configuration."}]">



</params-table>

```php [php]
$response = $client->workers()->scripts()->getContent('ACCOUNT_ID', 'SCRIPT_NAME');
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/operations/worker-script-get-content">

View this operation on the Cloudflare API Reference

</callout>

## Get Script Settings

Get script-level settings when using Worker Versions. Includes Logpush and Tail Consumers.

<params-table :params="[{"name":"accountId","type":"string","required":true,"description":"Account identifier."},{"name":"scriptName","type":"string","required":true,"description":"Name of the script, used in URLs and route configuration."}]">



</params-table>

```php [php]
$response = $client->workers()->scripts()->getScriptSettings('ACCOUNT_ID', 'SCRIPT_NAME');
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/operations/worker-script-settings-get-settings">

View this operation on the Cloudflare API Reference

</callout>

## Update Script Settings

Patch script-level settings when using Worker Versions. Includes Logpush and Tail Consumers.

<params-table :params="[{"name":"accountId","type":"string","required":true,"description":"Account identifier."},{"name":"scriptName","type":"string","required":true,"description":"Name of the script, used in URLs and route configuration."},{"name":"values","type":"array","required":true,"description":"Script settings values."}]">



</params-table>

```php [php]
$response = $client->workers()->scripts()->updateScriptSettings('ACCOUNT_ID', 'SCRIPT_NAME', []);
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/operations/worker-script-settings-patch-settings">

View this operation on the Cloudflare API Reference

</callout>

## Get Settings

Get metadata and config, such as bindings or usage model

<params-table :params="[{"name":"accountId","type":"string","required":true,"description":"Account identifier."},{"name":"scriptName","type":"string","required":true,"description":"Name of the script, used in URLs and route configuration."}]">



</params-table>

```php [php]
$response = $client->workers()->scripts()->getSettings('ACCOUNT_ID', 'SCRIPT_NAME');
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/operations/worker-script-get-settings">

View this operation on the Cloudflare API Reference

</callout>

## Update Settings

Patch metadata or config, such as bindings or usage model

<params-table :params="[{"name":"accountId","type":"string","required":true,"description":"Account identifier."},{"name":"scriptName","type":"string","required":true,"description":"Name of the script, used in URLs and route configuration."},{"name":"values","type":"array","required":true,"description":"Settings values."}]">



</params-table>

```php [php]
$response = $client->workers()->scripts()->updateSettings('ACCOUNT_ID', 'SCRIPT_NAME', []);
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/operations/worker-script-patch-settings">

View this operation on the Cloudflare API Reference

</callout>

## Get Usage Model

Fetches the Usage Model for a given Worker.

<params-table :params="[{"name":"accountId","type":"string","required":true,"description":"Account identifier."},{"name":"scriptName","type":"string","required":true,"description":"Name of the script, used in URLs and route configuration."}]">



</params-table>

```php [php]
$response = $client->workers()->scripts()->getUsageModel('ACCOUNT_ID', 'SCRIPT_NAME');
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/operations/worker-script-fetch-usage-model">

View this operation on the Cloudflare API Reference

</callout>

## Update Usage Model

Updates the Usage Model for a given Worker. Requires a Workers Paid subscription.

<params-table :params="[{"name":"accountId","type":"string","required":true,"description":"Account identifier."},{"name":"scriptName","type":"string","required":true,"description":"Name of the script, used in URLs and route configuration."},{"name":"usageModel","type":"string","required":true,"description":"Usage model."}]">



</params-table>

```php [php]
$response = $client->workers()->scripts()->updateUsageModel('ACCOUNT_ID', 'SCRIPT_NAME', 'USAGE_MODEL');
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/operations/worker-script-update-usage-model">

View this operation on the Cloudflare API Reference

</callout>

## Delete

Delete your worker. This call has no response body on a successful delete.

<params-table :params="[{"name":"accountId","type":"string","required":true,"description":"Account identifier."},{"name":"scriptName","type":"string","required":true,"description":"Name of the script, used in URLs and route configuration."},{"name":"force","type":"bool","required":false,"description":"If set to true, delete will not be stopped by associated service binding, durable object, or other binding. Any of these associated bindings/durable objects will be deleted along with the script.","default":"false"}]">



</params-table>

```php [php]
$response = $client->workers()->scripts()->delete('ACCOUNT_ID', 'SCRIPT_NAME', true);
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/operations/worker-script-delete-worker">

View this operation on the Cloudflare API Reference

</callout>
