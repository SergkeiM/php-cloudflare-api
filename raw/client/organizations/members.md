# Members

> Members endpoint reference.

## List

List members of an organization.

<params-table :params="[{"name":"organizationId","type":"string","required":true,"description":"Organization identifier."},{"name":"params","type":"array","required":false,"description":"Array containing the necessary params, e.g. status, user.email.","default":"[]"}]">



</params-table>

```php [php]
$response = $client->organizations()->members()->list('ORGANIZATION_ID', []);
```

## Create

Add a member to an organization.

<params-table :params="[{"name":"organizationId","type":"string","required":true,"description":"Organization identifier."},{"name":"values","type":"array","required":true,"description":"Values, requires member."}]">



</params-table>

```php [php]
$response = $client->organizations()->members()->create('ORGANIZATION_ID', []);
```

## Batch Create

Add multiple members to an organization in a single request.

<params-table :params="[{"name":"organizationId","type":"string","required":true,"description":"Organization identifier."},{"name":"values","type":"array","required":true,"description":"Values, requires members."}]">



</params-table>

```php [php]
$response = $client->organizations()->members()->batchCreate('ORGANIZATION_ID', []);
```

## Get

Get information about a specific member of an organization.

<params-table :params="[{"name":"organizationId","type":"string","required":true,"description":"Organization identifier."},{"name":"memberId","type":"string","required":true,"description":"Member identifier."}]">



</params-table>

```php [php]
$response = $client->organizations()->members()->get('ORGANIZATION_ID', 'MEMBER_ID');
```

## Delete

Remove a member from an organization.

<params-table :params="[{"name":"organizationId","type":"string","required":true,"description":"Organization identifier."},{"name":"memberId","type":"string","required":true,"description":"Member identifier."}]">



</params-table>

```php [php]
$response = $client->organizations()->members()->delete('ORGANIZATION_ID', 'MEMBER_ID');
```
