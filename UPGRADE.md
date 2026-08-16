# Upgrade guide

## 0.5 to 1.0

Most of this release is additive — 0.5 wrapped six top-level resources, 1.0 wraps
twenty-six. The breaking part is that endpoints now sit where Cloudflare's own
documentation puts them, so several accessors moved.

Nothing else changed in how you call the library: the client is constructed the
same way, responses are the same objects, and the method names on each endpoint
are unchanged unless listed below.

### Accessors that moved

| 0.5 | 1.0 |
| --- | --- |
| `$client->tunnel()->routes()` | `$client->zeroTrust()->networks()->routes()` |
| `$client->tunnel()->virtualNetworks()` | `$client->zeroTrust()->networks()->virtualNetworks()` |
| `$client->workers()->kv()` | `$client->kv()` |
| `$client->workers()->durableObjects()` | `$client->durableObjects()` |
| `$client->zones()->cache()` | `$client->cache()` |
| `$client->zones()->cloudConnector()` | `$client->cloudConnector()` |
| `$client->zones()->dns()` | `$client->dns()` |
| `$client->zones()->dnssec()` | `$client->dns()->dnssec()` |
| `$client->zones()->pageRules()` | `$client->pageRules()` |
| `$client->zones()->rulesets()` | `$client->rulesets()` |
| `$client->zones()->lockdowns()` | `$client->firewall()->lockdowns()` |
| `$client->accounts()->rulesets()` | `$client->rulesets()` |
| `$client->accounts()->auditLogs()` | `$client->accounts()->logs()->audit()` |

`$client->accounts()`, `$client->d1()`, `$client->ips()`, `$client->workers()`
and `$client->zones()` are unchanged, as are the endpoints reached through them
that are not in the table.

Rulesets are scoped rather than nested, so the account and zone forms are now one
call taking whichever identifier applies:

```php
// 0.5
$client->zones()->rulesets()->list();
$client->accounts()->rulesets()->list();

// 1.0
$client->rulesets()->list(zoneId: 'ZONE_ID');
$client->rulesets()->list(accountId: 'ACCOUNT_ID');
```

### Write methods now take an array

Methods that used to spell the request body out as arguments now take it as one
`array $values`, the way most of the package already did. Cloudflare adds fields
to these bodies regularly, and an array absorbs a new field where a signature
would need another argument in a fixed position.

Several of these could not reach parts of the API at all before, noted below.

| 0.5 | 1.0 |
| --- | --- |
| `accounts()->create($name, $type, $unit)` | `accounts()->create(['name' => …, 'type' => …])` |
| `accounts()->update($id, $name, $settings)` | `accounts()->update($id, ['name' => …])` |
| `zones()->create($accountId, $name, $type)` | `zones()->create($accountId, ['name' => …])` |
| `zones()->edit($id, $type, $vanityNameServers)` | `zones()->edit($id, ['type' => …])` — now also reaches `paused` and `plan` |
| `d1()->create($accountId, $name, $location)` | `d1()->create($accountId, ['name' => …])` — now also reaches `read_replication` and `jurisdiction` |
| `dns()->dnssec()->edit($id, $status, $multiSigner, $presigned)` | `dns()->dnssec()->edit($id, ['status' => …])` — now also reaches `dnssec_use_nsec3` |
| `firewall()->lockdowns()->create($id, $value, $urls)` | `firewall()->lockdowns()->create($id, ['urls' => …, 'configurations' => …])` |
| `firewall()->lockdowns()->update($id, $lockdownId, $value, $urls)` | `firewall()->lockdowns()->update($id, $lockdownId, [...])` |
| `originCACertificates()->create($csr, $hostnames, $validity, $type)` | `originCACertificates()->create(['csr' => …, 'hostnames' => …, 'request_type' => …])` |
| `zeroTrust()->networks()->routes()->create($accountId, $network, $vnetId, $comment)` | `…->create($accountId, ['network' => …])` — now also reaches `tunnel_id` |
| `zeroTrust()->networks()->virtualNetworks()->create($accountId, $name, $isDefault, $comment)` | `…->create($accountId, ['name' => …])` |
| `workers()->settings()->create($accountId, $usageModel, $greenCompute)` | `workers()->settings()->create($accountId, ['default_usage_model' => …, 'green_compute' => …])` |
| `zones()->transformationFlows()->update($accountId, $zoneId, $flows, $etag, $version)` | `…->update($accountId, $zoneId, ['flows' => …, 'etag' => …])` |

Zone Lockdown deserves its own note. The old signature took a single `$value`
and guessed its target from whether it contained a `/`, so only `ip` and
`ip_range` were ever reachable. Configurations are now passed as Cloudflare
defines them, which also allows `asn` and `country`, several at once, and the
`description`, `priority` and `paused` fields:

```php
$client->firewall()->lockdowns()->create('ZONE_ID', [
    'urls' => ['example.com/admin*'],
    'configurations' => [
        ['target' => 'ip', 'value' => '198.51.100.4'],
        ['target' => 'country', 'value' => 'US'],
    ],
    'description' => 'Admin area',
]);
```

Two smaller changes in the same area: `zones()->create()` no longer sends
`type: 'full'` when you omit it, because Cloudflare applies its own default; and
`workers()->deployments()` methods take `$scriptName`, previously misspelled
`$scriptMame`, which matters only if you used named arguments.

### Accessors that are gone

| 0.5 | Why, and what to use |
| --- | --- |
| `$client->accounts()->roles()` | Cloudflare deprecated account roles. Use `$client->iam()` — permission groups, resource groups and user groups. |
| `$client->workers()->environment()` | Cloudflare retired the reference for the `services/{name}/environments/{env}` API. Use `$client->workers()->versions()` and `->deployments()`. |

### Namespaces that moved

Only relevant if you type-hint endpoint classes directly or extend them.

| 0.5 | 1.0 |
| --- | --- |
| `Cloudflare\Endpoints\Tunnel\Routes` | `Cloudflare\Endpoints\ZeroTrust\Networks\Routes` |
| `Cloudflare\Endpoints\Tunnel\VirtualNetworks` | `Cloudflare\Endpoints\ZeroTrust\Networks\VirtualNetworks` |
| `Cloudflare\Endpoints\Workers\KV` | `Cloudflare\Endpoints\KV` |
| `Cloudflare\Endpoints\Workers\DurableObjects` | `Cloudflare\Endpoints\DurableObjects` |
| `Cloudflare\Endpoints\Zones\Cache` | `Cloudflare\Endpoints\Cache` |
| `Cloudflare\Endpoints\Zones\CloudConnector` | `Cloudflare\Endpoints\CloudConnector` |
| `Cloudflare\Endpoints\Zones\DNS` | `Cloudflare\Endpoints\DNS` |
| `Cloudflare\Endpoints\Zones\DNSSEC` | `Cloudflare\Endpoints\DNS\DNSSEC` |
| `Cloudflare\Endpoints\Zones\Lockdown` | `Cloudflare\Endpoints\Firewall\Lockdowns` |
| `Cloudflare\Endpoints\Zones\PageRules` | `Cloudflare\Endpoints\PageRules` |
| `Cloudflare\Endpoints\Zones\Rulesets` | `Cloudflare\Endpoints\Rulesets` |
| `Cloudflare\Endpoints\Zones\Hold` | `Cloudflare\Endpoints\Zones\Holds` |
| `Cloudflare\Endpoints\Accounts\AuditLogs` | `Cloudflare\Endpoints\Accounts\Logs\Audit` |
| `Cloudflare\Endpoints\Accounts\Rulesets` | `Cloudflare\Endpoints\Rulesets` |

### Laravel

`illuminate/contracts` and `illuminate/support` moved from `require` to
`suggest`. A Laravel application already has both, so nothing changes there. A
non-Laravel project no longer pulls them in.

Lumen is no longer supported.

### Everything else

If an accessor you use is not listed here, it did not move. The
[client reference](https://sergkeim.github.io/php-cloudflare-api/client) lists
every endpoint at its current address.
