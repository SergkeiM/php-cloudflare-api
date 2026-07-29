# Domains

> Domains endpoint reference.

## List

Lists all Worker Domains for an account.

<params-table :params="[{"name":"accountId","type":"string","required":true,"description":"Account identifier."},{"name":"params","type":"array","required":false,"description":"Array containing the necessary params.","default":"[]"}]">



</params-table>

```php [php]
$response = $client->workers()->domains()->list('ACCOUNT_ID', []);
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/operations/worker-domain-list-domains">

View this operation on the Cloudflare API Reference

</callout>

## Attach

Attaches a Worker to a zone and hostname.

<params-table :params="[{"name":"accountId","type":"string","required":true,"description":"Account identifier."},{"name":"values","type":"array","required":false,"description":"Values to set on account.","default":"[]"}]">



</params-table>

```php [php]
$response = $client->workers()->domains()->attach('ACCOUNT_ID', []);
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/operations/worker-domain-attach-to-domain">

View this operation on the Cloudflare API Reference

</callout>

## Detach

Detaches a Worker from a zone and hostname.

<params-table :params="[{"name":"accountId","type":"string","required":true,"description":"Account identifier."},{"name":"domainId","type":"string","required":true,"description":"Identifer of the Worker Domain."}]">



</params-table>

```php [php]
$response = $client->workers()->domains()->detach('ACCOUNT_ID', 'DOMAIN_ID');
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/operations/worker-domain-detach-from-domain">

View this operation on the Cloudflare API Reference

</callout>

## Get

Gets a Worker domain.

<params-table :params="[{"name":"accountId","type":"string","required":true,"description":"Account identifier."},{"name":"domainId","type":"string","required":true,"description":"Identifer of the Worker Domain."}]">



</params-table>

```php [php]
$response = $client->workers()->domains()->get('ACCOUNT_ID', 'DOMAIN_ID');
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/operations/worker-domain-get-a-domain">

View this operation on the Cloudflare API Reference

</callout>
