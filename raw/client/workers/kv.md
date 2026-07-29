# KV

> KV endpoint reference.

## List

Returns the namespaces owned by an account.

<params-table :params="[{"name":"accountId","type":"string","required":true,"description":"Account identifier."},{"name":"params","type":"array","required":false,"description":"Array containing the necessary params.","default":"[]"}]">



</params-table>

```php [php]
$response = $client->workers()->kv()->list('ACCOUNT_ID', []);
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/operations/workers-kv-namespace-list-namespaces">

View this operation on the Cloudflare API Reference

</callout>

## Create

Creates a namespace under the given title. A 400 is returned if the account already owns a namespace with this title. A namespace must be explicitly deleted to be replaced.

<params-table :params="[{"name":"accountId","type":"string","required":true,"description":"Account identifier."},{"name":"title","type":"string","required":true,"description":"A human-readable string name for a Namespace."}]">



</params-table>

```php [php]
$response = $client->workers()->kv()->create('ACCOUNT_ID', 'TITLE');
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/operations/workers-kv-namespace-create-a-namespace">

View this operation on the Cloudflare API Reference

</callout>

## Get

Get the namespace corresponding to the given ID.

<params-table :params="[{"name":"accountId","type":"string","required":true,"description":"Account identifier."},{"name":"namespaceId","type":"string","required":true,"description":"Namespace identifier tag."}]">



</params-table>

```php [php]
$response = $client->workers()->kv()->get('ACCOUNT_ID', 'NAMESPACE_ID');
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/operations/workers-kv-namespace-get-a-namespace">

View this operation on the Cloudflare API Reference

</callout>

## Update

Modifies a namespace's title.

<params-table :params="[{"name":"accountId","type":"string","required":true,"description":"Account identifier."},{"name":"namespaceId","type":"string","required":true,"description":"Namespace identifier tag."},{"name":"title","type":"string","required":true,"description":"A human-readable string name for a Namespace."}]">



</params-table>

```php [php]
$response = $client->workers()->kv()->update('ACCOUNT_ID', 'NAMESPACE_ID', 'TITLE');
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/operations/workers-kv-namespace-rename-a-namespace">

View this operation on the Cloudflare API Reference

</callout>

## Delete

Deletes the namespace corresponding to the given ID.

<params-table :params="[{"name":"accountId","type":"string","required":true,"description":"Account identifier."},{"name":"namespaceId","type":"string","required":true,"description":"Namespace identifier tag."}]">



</params-table>

```php [php]
$response = $client->workers()->kv()->delete('ACCOUNT_ID', 'NAMESPACE_ID');
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/operations/workers-kv-namespace-remove-a-namespace">

View this operation on the Cloudflare API Reference

</callout>

## List Keys

Lists a namespace keys.

<params-table :params="[{"name":"accountId","type":"string","required":true,"description":"Account identifier."},{"name":"namespaceId","type":"string","required":true,"description":"Namespace identifier tag."},{"name":"params","type":"array","required":false,"description":"Array containing the necessary params.","default":"[]"}]">



</params-table>

```php [php]
$response = $client->workers()->kv()->listKeys('ACCOUNT_ID', 'NAMESPACE_ID', []);
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/operations/workers-kv-namespace-list-a-namespace'-s-keys">

View this operation on the Cloudflare API Reference

</callout>

## Key Metadata

Returns the metadata associated with the given key in the given namespace. Use URL-encoding to use special characters (for example, `:`, `!`, `%`) in the key name.

<params-table :params="[{"name":"accountId","type":"string","required":true,"description":"Account identifier."},{"name":"namespaceId","type":"string","required":true,"description":"Namespace identifier tag."},{"name":"keyName","type":"string","required":true,"description":"A key's name. The name may be at most 512 bytes. All printable, non-whitespace characters are valid. Use percent-encoding to define key names as part of a URL."}]">



</params-table>

```php [php]
$response = $client->workers()->kv()->keyMetadata('ACCOUNT_ID', 'NAMESPACE_ID', 'KEY_NAME');
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/operations/workers-kv-namespace-list-a-namespace'-s-keys">

View this operation on the Cloudflare API Reference

</callout>

## Key Details

Returns the value associated with the given key in the given namespace. Use URL-encoding to use special characters (for example, `:`, `!`, `%`) in the key name. If the KV-pair is set to expire at some point, the expiration time as measured in seconds since the UNIX epoch will be returned in the expiration response header.

<params-table :params="[{"name":"accountId","type":"string","required":true,"description":"Account identifier."},{"name":"namespaceId","type":"string","required":true,"description":"Namespace identifier tag."},{"name":"keyName","type":"string","required":true,"description":"A key's name. The name may be at most 512 bytes. All printable, non-whitespace characters are valid. Use percent-encoding to define key names as part of a URL."}]">



</params-table>

```php [php]
$response = $client->workers()->kv()->keyDetails('ACCOUNT_ID', 'NAMESPACE_ID', 'KEY_NAME');
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/operations/workers-kv-namespace-read-key-value-pair">

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
$response = $client->workers()->kv()->writeKeyWithMetadata('ACCOUNT_ID', 'NAMESPACE_ID', 'KEY_NAME', []);
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/operations/workers-kv-namespace-create-a-namespace">

View this operation on the Cloudflare API Reference

</callout>

## Delete Key

Remove multiple KV pairs from the namespace. Body should be an array of up to 10,000 keys to be removed.

<params-table :params="[{"name":"accountId","type":"string","required":true,"description":"Account identifier."},{"name":"namespaceId","type":"string","required":true,"description":"Namespace identifier tag."},{"name":"keyName","type":"string","required":true,"description":"A key's name. The name may be at most 512 bytes. All printable, non-whitespace characters are valid. Use percent-encoding to define key names as part of a URL."}]">



</params-table>

```php [php]
$response = $client->workers()->kv()->deleteKey('ACCOUNT_ID', 'NAMESPACE_ID', 'KEY_NAME');
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/operations/workers-kv-namespace-delete-multiple-key-value-pairs">

View this operation on the Cloudflare API Reference

</callout>

## Write Multiple Keys

Write multiple keys and values at once. Body should be an array of up to 10,000 key-value pairs to be stored, along with optional expiration information.

Existing values and expirations will be overwritten. If neither `expiration` nor `expiration_ttl` is specified, the key-value pair will never expire.
If both are set, `expiration_ttl` is used and `expiration` is ignored. The entire request size must be 100 megabytes or less.

<params-table :params="[{"name":"accountId","type":"string","required":true,"description":"Account identifier."},{"name":"namespaceId","type":"string","required":true,"description":"Namespace identifier tag."},{"name":"values","type":"array","required":true,"description":"keys and values."}]">



</params-table>

```php [php]
$response = $client->workers()->kv()->writeMultipleKeys('ACCOUNT_ID', 'NAMESPACE_ID', []);
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/operations/workers-kv-namespace-write-multiple-key-value-pairs">

View this operation on the Cloudflare API Reference

</callout>

## Delete Multiple Keys

Remove multiple KV pairs from the namespace. Body should be an array of up to 10,000 keys to be removed.

<params-table :params="[{"name":"accountId","type":"string","required":true,"description":"Account identifier."},{"name":"namespaceId","type":"string","required":true,"description":"Namespace identifier tag."},{"name":"keys","type":"array","required":true,"description":"Keys."}]">



</params-table>

```php [php]
$response = $client->workers()->kv()->deleteMultipleKeys('ACCOUNT_ID', 'NAMESPACE_ID', []);
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/operations/workers-kv-namespace-delete-multiple-key-value-pairs">

View this operation on the Cloudflare API Reference

</callout>
