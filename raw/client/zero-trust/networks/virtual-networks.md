# Virtual Networks

> Virtual Networks endpoint reference.

## List

Lists and filters virtual networks in an account.

<params-table :params="[{"name":"accountId","type":"string","required":true,"description":"Account identifier."},{"name":"params","type":"array","required":false,"description":"Array containing the necessary params.","default":"[]"}]">



</params-table>

```php [php]
$response = $client->zeroTrust()->networks()->virtualNetworks()->list('ACCOUNT_ID', []);
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/resources/zero_trust/subresources/networks/subresources/virtual_networks/methods/list/">

View this operation on the Cloudflare API Reference

</callout>

## Create

Adds a new virtual network to an account.

<params-table :params="[{"name":"accountId","type":"string","required":true,"description":"Account identifier."},{"name":"values","type":"array","required":true,"description":"`name` is required. `is_default` makes this the account's default virtual network, and `comment` describes it."}]">



</params-table>

```php [php]
$response = $client->zeroTrust()->networks()->virtualNetworks()->create('ACCOUNT_ID', []);
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/resources/zero_trust/subresources/networks/subresources/virtual_networks/methods/create/">

View this operation on the Cloudflare API Reference

</callout>

## Get

Get a virtual network.

<params-table :params="[{"name":"accountId","type":"string","required":true,"description":"Account identifier."},{"name":"virtualNetworkId","type":"string","required":true,"description":"UUID of the virtual network."}]">



</params-table>

```php [php]
$response = $client->zeroTrust()->networks()->virtualNetworks()->get('ACCOUNT_ID', 'VIRTUAL_NETWORK_ID');
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/resources/zero_trust/subresources/networks/subresources/virtual_networks/methods/get/">

View this operation on the Cloudflare API Reference

</callout>

## Edit

Updates an existing virtual network.

<params-table :params="[{"name":"accountId","type":"string","required":true,"description":"Account identifier."},{"name":"virtualNetworkId","type":"string","required":true,"description":"UUID of the virtual network."},{"name":"values","type":"array","required":false,"description":"he fields that are meant to be updated","default":"[]"}]">



</params-table>

```php [php]
$response = $client->zeroTrust()->networks()->virtualNetworks()->edit('ACCOUNT_ID', 'VIRTUAL_NETWORK_ID', []);
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/resources/zero_trust/subresources/networks/subresources/virtual_networks/methods/edit/">

View this operation on the Cloudflare API Reference

</callout>

## Delete

Deletes an existing virtual network.

<params-table :params="[{"name":"accountId","type":"string","required":true,"description":"Account identifier."},{"name":"virtualNetworkId","type":"string","required":true,"description":"UUID of the virtual network."}]">



</params-table>

```php [php]
$response = $client->zeroTrust()->networks()->virtualNetworks()->delete('ACCOUNT_ID', 'VIRTUAL_NETWORK_ID');
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/resources/zero_trust/subresources/networks/subresources/virtual_networks/methods/delete/">

View this operation on the Cloudflare API Reference

</callout>
