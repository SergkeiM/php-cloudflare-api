# KV

> KV endpoint reference.

## List

Returns the namespaces owned by an account.

<params-table :params="[{"name":"accountId","type":"string","required":true,"description":"Account identifier."},{"name":"params","type":"array","required":false,"description":"Array containing the necessary params.","default":"[]"}]">



</params-table>

```php [php]
$response = $client->kv()->list('ACCOUNT_ID', []);
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/resources/kv/subresources/namespaces/methods/list/">

View this operation on the Cloudflare API Reference

</callout>

## Create

Creates a namespace under the given title. A 400 is returned if the account already owns a namespace with this title. A namespace must be explicitly deleted to be replaced.

<params-table :params="[{"name":"accountId","type":"string","required":true,"description":"Account identifier."},{"name":"title","type":"string","required":true,"description":"A human-readable string name for a Namespace."}]">



</params-table>

```php [php]
$response = $client->kv()->create('ACCOUNT_ID', 'TITLE');
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/resources/kv/subresources/namespaces/methods/create/">

View this operation on the Cloudflare API Reference

</callout>

## Get

Get the namespace corresponding to the given ID.

<params-table :params="[{"name":"accountId","type":"string","required":true,"description":"Account identifier."},{"name":"namespaceId","type":"string","required":true,"description":"Namespace identifier tag."}]">



</params-table>

```php [php]
$response = $client->kv()->get('ACCOUNT_ID', 'NAMESPACE_ID');
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/resources/kv/subresources/namespaces/methods/get/">

View this operation on the Cloudflare API Reference

</callout>

## Update

Modifies a namespace's title.

<params-table :params="[{"name":"accountId","type":"string","required":true,"description":"Account identifier."},{"name":"namespaceId","type":"string","required":true,"description":"Namespace identifier tag."},{"name":"title","type":"string","required":true,"description":"A human-readable string name for a Namespace."}]">



</params-table>

```php [php]
$response = $client->kv()->update('ACCOUNT_ID', 'NAMESPACE_ID', 'TITLE');
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/resources/kv/subresources/namespaces/methods/update/">

View this operation on the Cloudflare API Reference

</callout>

## Delete

Deletes the namespace corresponding to the given ID.

<params-table :params="[{"name":"accountId","type":"string","required":true,"description":"Account identifier."},{"name":"namespaceId","type":"string","required":true,"description":"Namespace identifier tag."}]">



</params-table>

```php [php]
$response = $client->kv()->delete('ACCOUNT_ID', 'NAMESPACE_ID');
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/resources/kv/subresources/namespaces/methods/delete/">

View this operation on the Cloudflare API Reference

</callout>

## List Keys

Lists a namespace keys.

<params-table :params="[{"name":"accountId","type":"string","required":true,"description":"Account identifier."},{"name":"namespaceId","type":"string","required":true,"description":"Namespace identifier tag."},{"name":"params","type":"array","required":false,"description":"Array containing the necessary params.","default":"[]"}]">



</params-table>

```php [php]
$response = $client->kv()->listKeys('ACCOUNT_ID', 'NAMESPACE_ID', []);
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/resources/kv/subresources/namespaces/subresources/keys/methods/list/">

View this operation on the Cloudflare API Reference

</callout>

## Key Metadata

Returns the metadata associated with the given key in the given namespace. Use URL-encoding to use special characters (for example, `:`, `!`, `%`) in the key name.

<params-table :params="[{"name":"accountId","type":"string","required":true,"description":"Account identifier."},{"name":"namespaceId","type":"string","required":true,"description":"Namespace identifier tag."},{"name":"keyName","type":"string","required":true,"description":"A key's name. The name may be at most 512 bytes. All printable, non-whitespace characters are valid. Use percent-encoding to define key names as part of a URL."}]">



</params-table>

```php [php]
$response = $client->kv()->keyMetadata('ACCOUNT_ID', 'NAMESPACE_ID', 'KEY_NAME');
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/resources/kv/subresources/namespaces/subresources/metadata/methods/get/">

View this operation on the Cloudflare API Reference

</callout>

## Key Details

Returns the value associated with the given key in the given namespace. Use URL-encoding to use special characters (for example, `:`, `!`, `%`) in the key name. If the KV-pair is set to expire at some point, the expiration time as measured in seconds since the UNIX epoch will be returned in the expiration response header.

<params-table :params="[{"name":"accountId","type":"string","required":true,"description":"Account identifier."},{"name":"namespaceId","type":"string","required":true,"description":"Namespace identifier tag."},{"name":"keyName","type":"string","required":true,"description":"A key's name. The name may be at most 512 bytes. All printable, non-whitespace characters are valid. Use percent-encoding to define key names as part of a URL."}]">



</params-table>

```php [php]
$response = $client->kv()->keyDetails('ACCOUNT_ID', 'NAMESPACE_ID', 'KEY_NAME');
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/resources/kv/subresources/namespaces/subresources/values/methods/get/">

View this operation on the Cloudflare API Reference

</callout>

## Write Key With Metadata

Write a value identified by a key. Use URL-encoding to use special characters (for example, `:`, `!`, `%`) in the key name.

Body should be the value to be stored along with JSON metadata to be associated with the key/value pair.
Existing values, expirations, and metadata will be overwritten. If neither `expiration` nor `expiration_ttl` is specified, the key-value pair will never expire.
If both are set, `expiration_ttl` is used and `expiration` is ignored.

<params-table :params="[{"name":"accountId","type":"string","required":true,"description":"Account identifier."},{"name":"namespaceId","type":"string","required":true,"description":"Namespace identifier tag."},{"name":"keyName","type":"string","required":true,"description":"A key's name. The name may be at most 512 bytes. All printable, non-whitespace characters are valid. Use percent-encoding to define key names as part of a URL."},{"name":"values","type":"array","required":true,"description":"keys and values."}]">



</params-table>

```php [php]
$response = $client->kv()->writeKeyWithMetadata('ACCOUNT_ID', 'NAMESPACE_ID', 'KEY_NAME', []);
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/resources/kv/subresources/namespaces/subresources/values/methods/update/">

View this operation on the Cloudflare API Reference

</callout>

## Delete Key

Remove multiple KV pairs from the namespace. Body should be an array of up to 10,000 keys to be removed.

<params-table :params="[{"name":"accountId","type":"string","required":true,"description":"Account identifier."},{"name":"namespaceId","type":"string","required":true,"description":"Namespace identifier tag."},{"name":"keyName","type":"string","required":true,"description":"A key's name. The name may be at most 512 bytes. All printable, non-whitespace characters are valid. Use percent-encoding to define key names as part of a URL."}]">



</params-table>

```php [php]
$response = $client->kv()->deleteKey('ACCOUNT_ID', 'NAMESPACE_ID', 'KEY_NAME');
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/resources/kv/subresources/namespaces/subresources/values/methods/delete/">

View this operation on the Cloudflare API Reference

</callout>

## Write Multiple Keys

Write multiple keys and values at once. Body should be an array of up to 10,000 key-value pairs to be stored, along with optional expiration information.

Existing values and expirations will be overwritten. If neither `expiration` nor `expiration_ttl` is specified, the key-value pair will never expire.
If both are set, `expiration_ttl` is used and `expiration` is ignored. The entire request size must be 100 megabytes or less.

<params-table :params="[{"name":"accountId","type":"string","required":true,"description":"Account identifier."},{"name":"namespaceId","type":"string","required":true,"description":"Namespace identifier tag."},{"name":"values","type":"array","required":true,"description":"keys and values."}]">



</params-table>

```php [php]
$response = $client->kv()->writeMultipleKeys('ACCOUNT_ID', 'NAMESPACE_ID', []);
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/resources/kv/subresources/namespaces/methods/bulk_update/">

View this operation on the Cloudflare API Reference

</callout>

## Delete Multiple Keys

Remove multiple KV pairs from the namespace. Body should be an array of up to 10,000 keys to be removed.

<params-table :params="[{"name":"accountId","type":"string","required":true,"description":"Account identifier."},{"name":"namespaceId","type":"string","required":true,"description":"Namespace identifier tag."},{"name":"keys","type":"array","required":true,"description":"Keys."}]">



</params-table>

```php [php]
$response = $client->kv()->deleteMultipleKeys('ACCOUNT_ID', 'NAMESPACE_ID', []);
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/resources/kv/subresources/namespaces/methods/bulk_delete/">

View this operation on the Cloudflare API Reference

</callout>

## Get Multiple Keys

Read multiple KV pairs from the namespace, up to 100 at a time. The values must be text-based.

Unlike the other bulk operations, which take up to 10,000 keys, this one
is capped at 100. Values come back as strings unless `type` is `json`, in
which case Cloudflare parses them for you.

```php
$client->kv()->getMultipleKeys('ACCOUNT_ID', 'NAMESPACE_ID', ['key-a', 'key-b'], 'json', true);
```

<params-table :params="[{"name":"accountId","type":"string","required":true,"description":"Account identifier."},{"name":"namespaceId","type":"string","required":true,"description":"Namespace identifier tag."},{"name":"keys","type":"array","required":true,"description":"Keys to retrieve, at most 100 of them."},{"name":"type","type":"string","required":false,"description":"Whether to parse JSON values in the response: `text` or `json`.","default":"'text'"},{"name":"withMetadata","type":"bool","required":false,"description":"Whether to include each key's metadata in the response.","default":"false"}]">



</params-table>

```php [php]
$response = $client->kv()->getMultipleKeys('ACCOUNT_ID', 'NAMESPACE_ID', [], 'TYPE', true);
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/resources/kv/subresources/namespaces/methods/bulk_get/">

View this operation on the Cloudflare API Reference

</callout>
