# User

> User endpoint reference.

## Get

Retrieves detailed information about the currently authenticated user, including email, name, and account memberships.

```php [php]
$response = $client->user()->get();
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/operations/user-user-details">

View this operation on the Cloudflare API Reference

</callout>

## Update

Edit part of your user details.

<params-table :params="[{"name":"values","type":"array","required":false,"description":"User values, e.g. first_name, last_name, telephone, country, zipcode.","default":"[]"}]">



</params-table>

```php [php]
$response = $client->user()->update([]);
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/operations/user-edit-user">

View this operation on the Cloudflare API Reference

</callout>

## Related

- [Audit Logs](/client/user/audit-logs)
- [Invites](/client/user/invites)
- [Subscriptions](/client/user/subscriptions)
- [Tenants](/client/user/tenants)
- [Tokens](/client/user/tokens)
