# Organizations

> Organizations endpoint reference.

## List

Retrieve a list of organizations a particular user has access to.

<params-table :params="[{"name":"params","type":"array","required":false,"description":"Array containing the necessary params.","default":"[]"}]">



</params-table>

```php [php]
$response = $client->organizations()->list([]);
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/resources/organizations/methods/list/">

View this operation on the Cloudflare API Reference

</callout>

## Create

Create a new organization for a user.

<params-table :params="[{"name":"values","type":"array","required":true,"description":"Organization values, requires name."}]">



</params-table>

```php [php]
$response = $client->organizations()->create([]);
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/resources/organizations/methods/create/">

View this operation on the Cloudflare API Reference

</callout>

## Get

Retrieve the details of a certain organization.

<params-table :params="[{"name":"organizationId","type":"string","required":true,"description":"Organization identifier."}]">



</params-table>

```php [php]
$response = $client->organizations()->get('ORGANIZATION_ID');
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/resources/organizations/methods/get/">

View this operation on the Cloudflare API Reference

</callout>

## Update

Modify organization.

<params-table :params="[{"name":"organizationId","type":"string","required":true,"description":"Organization identifier."},{"name":"values","type":"array","required":false,"description":"Organization values, e.g. name.","default":"[]"}]">



</params-table>

```php [php]
$response = $client->organizations()->update('ORGANIZATION_ID', []);
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/resources/organizations/methods/update/">

View this operation on the Cloudflare API Reference

</callout>

## Delete

Delete an organization. The organization MUST be empty before deleting.

<params-table :params="[{"name":"organizationId","type":"string","required":true,"description":"Organization identifier."}]">



</params-table>

```php [php]
$response = $client->organizations()->delete('ORGANIZATION_ID');
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/resources/organizations/methods/delete/">

View this operation on the Cloudflare API Reference

</callout>

## Accounts

List the accounts that belong to an organization.

Filters come in four flavours for both `name` and `account_pubname`: an
exact match, or one of `.startsWith`, `.endsWith` and `.contains`. All of
them are case-insensitive.

Paging here is by opaque token rather than page number: pass the
`page_token` from the previous response to get the next page.

```php
$client->organizations()->accounts('ORGANIZATION_ID', [
    'name.startsWith' => 'prod',
    'order_by' => 'account_name',
]);
```

<params-table :params="[{"name":"organizationId","type":"string","required":true,"description":"Organization identifier."},{"name":"params","type":"array","required":false,"description":"Query Parameters: `account_pubname` and `name` — each also accepting `.startsWith`, `.endsWith` and `.contains` — plus `order_by` (`account_name`), `direction` (`asc` or `desc`), `page_token` and `page_size` (defaults to `10`).","default":"[]"}]">



</params-table>

```php [php]
$response = $client->organizations()->accounts('ORGANIZATION_ID', []);
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/fundamentals/organizations/">

View this operation on the Cloudflare API Reference

</callout>

## Shares

List an organization's shares.

<params-table :params="[{"name":"organizationId","type":"string","required":true,"description":"Organization identifier."},{"name":"params","type":"array","required":false,"description":"Query Parameters: `status` (`active`, `deleting` or `deleted`), `kind` (`sent` or `received`), `target_type` (`account` or `organization`), `resource_types`, `order` (`name` or `created`), `direction` (`asc` or `desc`), `page` and `per_page`.","default":"[]"}]">



</params-table>

```php [php]
$response = $client->organizations()->shares('ORGANIZATION_ID', []);
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/fundamentals/organizations/">

View this operation on the Cloudflare API Reference

</callout>

## Related

- [Profile](/client/organizations/profile)
- [Logs](/client/organizations/logs)
- [Billing](/client/organizations/billing)
- [Members](/client/organizations/members)
