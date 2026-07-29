# Versions

> Versions endpoint reference.

## List

List of Worker Versions. The first version in the list is the latest version.

<params-table :params="[{"name":"accountId","type":"string","required":true,"description":"Account identifier."},{"name":"scriptName","type":"string","required":true,"description":"Name of the script, used in URLs and route configuration."},{"name":"params","type":"array","required":false,"description":"Array containing the necessary params.","default":"[]"}]">



</params-table>

```php [php]
$response = $client->workers()->versions()->list('ACCOUNT_ID', 'SCRIPT_NAME', []);
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/operations/worker-versions-list-versions">

View this operation on the Cloudflare API Reference

</callout>

## Upload

Upload a Worker Version without deploying to Cloudflare's network. You can find more about the multipart metadata on [Cloudflare docs](https://developers.cloudflare.com/workers/configuration/multipart-upload-metadata/).

<params-table :params="[{"name":"accountId","type":"string","required":true,"description":"Account identifier."},{"name":"scriptName","type":"string","required":true,"description":"Name of the script, used in URLs and route configuration."}]">



</params-table>

```php [php]
$response = $client->workers()->versions()->upload('ACCOUNT_ID', 'SCRIPT_NAME');
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/operations/worker-versions-upload-version">

View this operation on the Cloudflare API Reference

</callout>

## Get

Get Version Details.

<params-table :params="[{"name":"accountId","type":"string","required":true,"description":"Account identifier."},{"name":"scriptName","type":"string","required":true,"description":"Name of the script, used in URLs and route configuration."},{"name":"versionId","type":"string","required":true,"description":"Version identifier."}]">



</params-table>

```php [php]
$response = $client->workers()->versions()->get('ACCOUNT_ID', 'SCRIPT_NAME', 'VERSION_ID');
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/operations/worker-versions-get-version-detail">

View this operation on the Cloudflare API Reference

</callout>
