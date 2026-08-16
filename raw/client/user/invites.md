# Invites

> Invites endpoint reference.

## List

Lists all invitations associated with my user.

```php [php]
$response = $client->user()->invites()->list();
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/resources/user/subresources/invites/methods/list/">

View this operation on the Cloudflare API Reference

</callout>

## Get

Gets the details of an invitation.

<params-table :params="[{"name":"inviteId","type":"string","required":true,"description":"Invite identifier tag."}]">



</params-table>

```php [php]
$response = $client->user()->invites()->get('INVITE_ID');
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/resources/user/subresources/invites/methods/get/">

View this operation on the Cloudflare API Reference

</callout>

## Respond

Responds to an invitation.

<params-table :params="[{"name":"inviteId","type":"string","required":true,"description":"Invite identifier tag."},{"name":"status","type":"string","required":true,"description":"Status of the invitation, e.g. accepted, rejected."}]">



</params-table>

```php [php]
$response = $client->user()->invites()->respond('INVITE_ID', 'STATUS');
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/resources/user/subresources/invites/methods/edit/">

View this operation on the Cloudflare API Reference

</callout>
