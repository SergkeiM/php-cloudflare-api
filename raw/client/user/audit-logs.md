# Audit Logs

> Audit Logs endpoint reference.

## List

Gets a list of audit logs for a user account. Can be filtered by who made the change, on which zone, and the timeframe of the change.

<params-table :params="[{"name":"params","type":"array","required":false,"description":"Array containing the necessary params.","default":"[]"}]">



</params-table>

```php [php]
$response = $client->user()->auditLogs()->list([]);
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/operations/audit-logs-get-user-audit-logs">

View this operation on the Cloudflare API Reference

</callout>
