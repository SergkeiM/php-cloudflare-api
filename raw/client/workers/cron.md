# Cron

> Cron endpoint reference.

## Get

Get Cron Triggers

<params-table :params="[{"name":"accountId","type":"string","required":true,"description":"Account identifier."},{"name":"scriptName","type":"string","required":true,"description":"Name of the script, used in URLs and route configuration."}]">



</params-table>

```php [php]
$response = $client->workers()->cron()->get('ACCOUNT_ID', 'SCRIPT_NAME');
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/operations/worker-cron-trigger-get-cron-triggers">

View this operation on the Cloudflare API Reference

</callout>

## Update

Updates Cron Triggers for a Worker.

<params-table :params="[{"name":"accountId","type":"string","required":true,"description":"Account identifier."},{"name":"scriptName","type":"string","required":true,"description":"Name of the script, used in URLs and route configuration."},{"name":"schedules","type":"array","required":true,"description":"Values to set on Script schedules."}]">



</params-table>

```php [php]
$response = $client->workers()->cron()->update('ACCOUNT_ID', 'SCRIPT_NAME', []);
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/operations/worker-cron-trigger-update-cron-triggers">

View this operation on the Cloudflare API Reference

</callout>
