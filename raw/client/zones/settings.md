# Settings

> Zone settings: the per-zone toggles behind the Cloudflare dashboard, from `always_use_https` and `min_tls_version` to `browser_cache_ttl`.

Zone settings: the per-zone toggles behind the Cloudflare dashboard, from
`always_use_https` and `min_tls_version` to `browser_cache_ttl`.

## Get

Fetch a single zone setting by name.

<params-table :params="[{"name":"zoneId","type":"string","required":true,"description":"Zone Identifier."},{"name":"settingId","type":"string","required":true,"description":"Setting name, e.g. `always_use_https`."}]">



</params-table>

```php [php]
$response = $client->zones()->settings()->get('ZONE_ID', 'SETTING_ID');
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/resources/zones/subresources/settings/methods/get/">

View this operation on the Cloudflare API Reference

</callout>

## Edit

Update a single zone setting by name.

Cloudflare accepts one of two bodies, depending on the setting: `value`
for nearly all of them, and `enabled` for the handful that take it, such
as `ssl_recommender`.

```php
$client->zones()->settings()->edit('ZONE_ID', 'always_use_https', ['value' => 'on']);
$client->zones()->settings()->edit('ZONE_ID', 'browser_cache_ttl', ['value' => 18000]);
$client->zones()->settings()->edit('ZONE_ID', 'ssl_recommender', ['enabled' => true]);
```

<params-table :params="[{"name":"zoneId","type":"string","required":true,"description":"Zone Identifier."},{"name":"settingId","type":"string","required":true,"description":"Setting name, e.g. `always_use_https`."},{"name":"values","type":"array","required":true,"description":"Setting value: `['value' => mixed]`, or `['enabled' => bool]` for the settings that take it."}]">



</params-table>

```php [php]
$response = $client->zones()->settings()->edit('ZONE_ID', 'SETTING_ID', []);
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/resources/zones/subresources/settings/methods/edit/">

View this operation on the Cloudflare API Reference

</callout>

## Replace Origin Tls Compliance Modes

Replace the Origin TLS Compliance Modes setting for a zone.

The one setting Cloudflare exposes a full-replace endpoint for: the modes
you send become the whole list, and any mode you leave out is removed. An
empty list clears the constraint. `fips` and `pqh` are supported today,
and Cloudflare may add more, so read the current value before writing if
you mean to keep what is already there.

```php
$client->zones()->settings()->replaceOriginTlsComplianceModes('ZONE_ID', ['fips']);
```

<params-table :params="[{"name":"zoneId","type":"string","required":true,"description":"Zone Identifier."},{"name":"modes","type":"array","required":true,"description":"TLS compliance modes constraining the key-exchange algorithms Cloudflare offers the origin, e.g. `['fips', 'pqh']`."}]">



</params-table>

```php [php]
$response = $client->zones()->settings()->replaceOriginTlsComplianceModes('ZONE_ID', []);
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/resources/origin_tls_compliance_modes/methods/update/">

View this operation on the Cloudflare API Reference

</callout>

## Delete Origin Tls Compliance Modes

Delete the Origin TLS Compliance Modes setting for a zone.

Removes the compliance constraint entirely, returning the zone to
Cloudflare's default of not filtering the key-exchange algorithm list it
offers the origin.

<params-table :params="[{"name":"zoneId","type":"string","required":true,"description":"Zone Identifier."}]">



</params-table>

```php [php]
$response = $client->zones()->settings()->deleteOriginTlsComplianceModes('ZONE_ID');
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/resources/origin_tls_compliance_modes/methods/delete/">

View this operation on the Cloudflare API Reference

</callout>
