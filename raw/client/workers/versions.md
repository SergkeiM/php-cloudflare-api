# Versions

> Versions endpoint reference.

## List

List of Worker Versions. The first version in the list is the latest version.

<params-table :params="[{"name":"accountId","type":"string","required":true,"description":"Account identifier."},{"name":"scriptName","type":"string","required":true,"description":"Name of the script, used in URLs and route configuration."},{"name":"params","type":"array","required":false,"description":"Array containing the necessary params.","default":"[]"}]">



</params-table>

```php [php]
$response = $client->workers()->versions()->list('ACCOUNT_ID', 'SCRIPT_NAME', []);
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/resources/workers/subresources/scripts/subresources/versions/methods/list/">

View this operation on the Cloudflare API Reference

</callout>

## Upload

Upload a Worker Version without deploying it to Cloudflare's network.

The request is a multipart upload: a JSON `metadata` part describing the
Worker, and one part per module holding its source. Deploy the version
afterwards with `$client->workers()->deployments()->create()`.

```php
$client->workers()->versions()->upload('ACCOUNT_ID', 'my-worker', [
    ['name' => 'worker.js', 'content' => file_get_contents('dist/worker.js')],
], [
    'compatibility_date' => '2026-01-01',
    'bindings' => [
        ['type' => 'plain_text', 'name' => 'MESSAGE', 'text' => 'Hello, world!'],
    ],
]);
```

<params-table :params="[{"name":"accountId","type":"string","required":true,"description":"Account identifier."},{"name":"scriptName","type":"string","required":true,"description":"Name of the script, used in URLs and route configuration."},{"name":"modules","type":"array","required":true,"description":"The modules making up the Worker. Each one is `['name' => 'worker.js', 'content' => '…']`, optionally with `'type'` to override the default `application/javascript+module`."},{"name":"metadata","type":"array","required":false,"description":"Multipart metadata: `compatibility_date`, `bindings`, `migrations`, `placement`, and so on. `main_module` defaults to the first module.","default":"[]"}]">



</params-table>

```php [php]
$response = $client->workers()->versions()->upload('ACCOUNT_ID', 'SCRIPT_NAME', [], []);
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/resources/workers/subresources/scripts/subresources/versions/methods/create/">

View this operation on the Cloudflare API Reference

</callout>

## Get

Get Version Details.

<params-table :params="[{"name":"accountId","type":"string","required":true,"description":"Account identifier."},{"name":"scriptName","type":"string","required":true,"description":"Name of the script, used in URLs and route configuration."},{"name":"versionId","type":"string","required":true,"description":"Version identifier."}]">



</params-table>

```php [php]
$response = $client->workers()->versions()->get('ACCOUNT_ID', 'SCRIPT_NAME', 'VERSION_ID');
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/resources/workers/subresources/scripts/subresources/versions/methods/get/">

View this operation on the Cloudflare API Reference

</callout>
