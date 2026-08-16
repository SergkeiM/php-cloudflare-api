# Members

> Members endpoint reference.

## List

List all the members attached to a user group.

<params-table :params="[{"name":"accountId","type":"string","required":true,"description":"Account identifier."},{"name":"userGroupId","type":"string","required":true,"description":"User Group identifier."},{"name":"params","type":"array","required":false,"description":"Array containing the necessary params, e.g. fuzzyEmail.","default":"[]"}]">



</params-table>

```php [php]
$response = $client->iam()->userGroups()->members()->list('ACCOUNT_ID', 'USER_GROUP_ID', []);
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/resources/iam/subresources/user_groups/subresources/members/methods/list/">

View this operation on the Cloudflare API Reference

</callout>

## Create

Add members to a User Group.

<params-table :params="[{"name":"accountId","type":"string","required":true,"description":"Account identifier."},{"name":"userGroupId","type":"string","required":true,"description":"User Group identifier."},{"name":"members","type":"array","required":true,"description":"Array of member identifiers to add, e.g. [['id' => 'member_id']]."}]">



</params-table>

```php [php]
$response = $client->iam()->userGroups()->members()->create('ACCOUNT_ID', 'USER_GROUP_ID', []);
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/resources/iam/subresources/user_groups/subresources/members/methods/create/">

View this operation on the Cloudflare API Reference

</callout>

## Update

Replace the set of members attached to a User Group.

<params-table :params="[{"name":"accountId","type":"string","required":true,"description":"Account identifier."},{"name":"userGroupId","type":"string","required":true,"description":"User Group identifier."},{"name":"members","type":"array","required":true,"description":"Array of member identifiers, e.g. [['id' => 'member_id']]."}]">



</params-table>

```php [php]
$response = $client->iam()->userGroups()->members()->update('ACCOUNT_ID', 'USER_GROUP_ID', []);
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/resources/iam/subresources/user_groups/subresources/members/methods/update/">

View this operation on the Cloudflare API Reference

</callout>

## Delete

Remove a member from a User Group.

<params-table :params="[{"name":"accountId","type":"string","required":true,"description":"Account identifier."},{"name":"userGroupId","type":"string","required":true,"description":"User Group identifier."},{"name":"memberId","type":"string","required":true,"description":"Member identifier."}]">



</params-table>

```php [php]
$response = $client->iam()->userGroups()->members()->delete('ACCOUNT_ID', 'USER_GROUP_ID', 'MEMBER_ID');
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/resources/iam/subresources/user_groups/subresources/members/methods/delete/">

View this operation on the Cloudflare API Reference

</callout>

## Get

Get information about a specific member of a User Group.

<params-table :params="[{"name":"accountId","type":"string","required":true,"description":"Account identifier."},{"name":"userGroupId","type":"string","required":true,"description":"User Group identifier."},{"name":"memberId","type":"string","required":true,"description":"Member identifier."}]">



</params-table>

```php [php]
$response = $client->iam()->userGroups()->members()->get('ACCOUNT_ID', 'USER_GROUP_ID', 'MEMBER_ID');
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/resources/iam/subresources/user_groups/subresources/members/methods/get/">

View this operation on the Cloudflare API Reference

</callout>
