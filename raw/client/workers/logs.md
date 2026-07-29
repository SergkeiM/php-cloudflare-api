# Logs

> Logs endpoint reference.

## List

Get list of tails currently deployed on a Worker.

<params-table :params="[{"name":"accountId","type":"string","required":true,"description":"Account identifier."},{"name":"scriptName","type":"string","required":true,"description":"Name of the script, used in URLs and route configuration."}]">



</params-table>

```php [php]
$response = $client->workers()->logs()->list('ACCOUNT_ID', 'SCRIPT_NAME');
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/operations/worker-tail-logs-list-tails">

View this operation on the Cloudflare API Reference

</callout>

## Start

Starts a tail that receives logs and exception from a Worker.

<params-table :params="[{"name":"accountId","type":"string","required":true,"description":"Account identifier."},{"name":"scriptName","type":"string","required":true,"description":"Name of the script, used in URLs and route configuration."}]">



</params-table>

```php [php]
$response = $client->workers()->logs()->start('ACCOUNT_ID', 'SCRIPT_NAME');
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/operations/worker-tail-logs-start-tail">

View this operation on the Cloudflare API Reference

</callout>

## Delete

Deletes a tail from a Worker.

<params-table :params="[{"name":"accountId","type":"string","required":true,"description":"Account identifier."},{"name":"scriptName","type":"string","required":true,"description":"Name of the script, used in URLs and route configuration."},{"name":"id","type":"string","required":true,"description":"Identifier for the tail."}]">



</params-table>

```php [php]
$response = $client->workers()->logs()->delete('ACCOUNT_ID', 'SCRIPT_NAME', 'ID');
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/operations/worker-tail-logs-delete-tail">

View this operation on the Cloudflare API Reference

</callout>
