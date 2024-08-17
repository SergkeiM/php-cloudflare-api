# Audit logs

## Get account audit logs

Gets a list of [audit logs](https://developers.cloudflare.com/api/operations/audit-logs-get-account-audit-logs) for an account. Can be filtered by who made the change, on which zone, and the timeframe of the change.

```php [php]
$response = $client->accounts()->auditLogs()->list('ACCOUNT_ID');
```