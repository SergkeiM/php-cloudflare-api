# Audit

> Audit endpoint reference.

## List

Gets a list of audit logs for an organization.

<params-table :params="[{"name":"organizationId","type":"string","required":true,"description":"Organization identifier."},{"name":"params","type":"array","required":false,"description":"Array containing the necessary params, requires since and before.","default":"[]"}]">



</params-table>

```php [php]
$response = $client->organizations()->logs()->audit()->list('ORGANIZATION_ID', []);
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/operations/audit-logs-v2-get-organization-audit-logs">

View this operation on the Cloudflare API Reference

</callout>

## History

Returns the chronological change history for the resource identified by the given organization-scoped audit log entry.

<params-table :params="[{"name":"organizationId","type":"string","required":true,"description":"Organization identifier."},{"name":"id","type":"string","required":true,"description":"Audit log entry identifier used to locate the resource."},{"name":"params","type":"array","required":false,"description":"Array containing the necessary params, requires action_time, since and before.","default":"[]"}]">



</params-table>

```php [php]
$response = $client->organizations()->logs()->audit()->history('ORGANIZATION_ID', 'ID', []);
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/operations/audit-logs-v2-get-organization-audit-log-history">

View this operation on the Cloudflare API Reference

</callout>
