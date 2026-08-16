# Memberships

> Memberships endpoint reference.

## List

List memberships of accounts the user can access.

<params-table :params="[{"name":"params","type":"array","required":false,"description":"Array containing the necessary params.","default":"[]"}]">



</params-table>

```php [php]
$response = $client->memberships()->list([]);
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/resources/memberships/methods/list/">

View this operation on the Cloudflare API Reference

</callout>

## Get

Get a specific membership.

<params-table :params="[{"name":"membershipId","type":"string","required":true,"description":"Membership identifier tag."}]">



</params-table>

```php [php]
$response = $client->memberships()->get('MEMBERSHIP_ID');
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/resources/memberships/methods/get/">

View this operation on the Cloudflare API Reference

</callout>

## Update

Accept or reject this account invitation.

<params-table :params="[{"name":"membershipId","type":"string","required":true,"description":"Membership identifier tag."},{"name":"status","type":"string","required":true,"description":"Status of this membership, e.g. accepted, rejected."}]">



</params-table>

```php [php]
$response = $client->memberships()->update('MEMBERSHIP_ID', 'STATUS');
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/resources/memberships/methods/update/">

View this operation on the Cloudflare API Reference

</callout>

## Delete

Remove the associated member from an account.

<params-table :params="[{"name":"membershipId","type":"string","required":true,"description":"Membership identifier tag."}]">



</params-table>

```php [php]
$response = $client->memberships()->delete('MEMBERSHIP_ID');
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/resources/memberships/methods/delete/">

View this operation on the Cloudflare API Reference

</callout>
