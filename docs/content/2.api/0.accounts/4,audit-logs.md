---
title: Audit logs
description: Audit logs summarize the history of changes made within your Cloudflare account. Audit logs include account level actions like login, as well as zone configuration changes.
---

# Audit logs

Audit logs summarize the history of changes made within your Cloudflare account. Audit logs include account level actions like login, as well as zone configuration changes.

:button-link[Cloudflare API docs]{href="https://developers.cloudflare.com/api/operations/audit-logs-get-account-audit-logs" blank}

## Get

Gets a list of audit logs for an account. Can be filtered by who made the change, on which zone, and the timeframe of the change.

```php [php]
$response = $client->accounts()->auditLogs()->list('ACCOUNT_ID');
```