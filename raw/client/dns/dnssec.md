# DNSSEC

> DNSSEC endpoint reference.

## Get

Details about DNSSEC status and configuration.

<params-table :params="[{"name":"zoneId","type":"string","required":true,"description":"Zone Identifier."}]">



</params-table>

```php [php]
$response = $client->dns()->dnssec()->get('ZONE_ID');
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/resources/dns/subresources/dnssec/methods/get/">

View this operation on the Cloudflare API Reference

</callout>

## Edit

Enable or disable DNSSEC.

<params-table :params="[{"name":"zoneId","type":"string","required":true,"description":"Zone Identifier."},{"name":"values","type":"array","required":true,"description":"`status` is `active` or `disabled`. `dnssec_multi_signer` lets several providers serve the signed zone at once, which is required before DNSKEY records can be added — see [Multi-signer DNSSEC](https://developers.cloudflare.com/dns/dnssec/multi-signer-dnssec/). `dnssec_presigned` transfers in a zone already signed elsewhere, see [Cloudflare as Secondary](https://developers.cloudflare.com/dns/zone-setups/zone-transfers/cloudflare-as-secondary/setup/#dnssec). `dnssec_use_nsec3` is also accepted."}]">



</params-table>

```php [php]
$response = $client->dns()->dnssec()->edit('ZONE_ID', []);
```

::callout{icon="i-simple-icons-cloudflare" to="[https://developers.cloudflare.com/api/resources/dns/subresources/dnssec/methods/edit/](https://developers.cloudflare.com/api/resources/dns/subresources/dnssec/methods/edit/) ```php
$client->dns()->dnssec()->edit('ZONE_ID', <span>

'status' => 'active'

</span>

);

```"}
View this operation on the Cloudflare API Reference
::

## Delete

Delete DNSSEC.

::params-table
---
params:
  - name: "zoneId"
    type: "string"
    required: true
    description: "Zone Identifier."
---
::

```php [php]
$response = $client->dns()->dnssec()->delete('ZONE_ID');
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/resources/dns/subresources/dnssec/methods/delete/">

View this operation on the Cloudflare API Reference

</callout>
