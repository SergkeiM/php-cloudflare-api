# Sso

> Sso endpoint reference.

## List

Lists all SSO connectors configured for the account.

<params-table :params="[{"name":"accountId","type":"string","required":true,"description":"Account identifier."}]">



</params-table>

```php [php]
$response = $client->iam()->sso()->list('ACCOUNT_ID');
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/operations/get-all-sso-connectors">

View this operation on the Cloudflare API Reference

</callout>

## Create

Creates a new SSO connector for logging into Cloudflare through an identity provider.

<params-table :params="[{"name":"accountId","type":"string","required":true,"description":"Account identifier."},{"name":"values","type":"array","required":true,"description":"SSO Connector values, requires email_domain."}]">



</params-table>

```php [php]
$response = $client->iam()->sso()->create('ACCOUNT_ID', []);
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/operations/init-new-sso-connector">

View this operation on the Cloudflare API Reference

</callout>

## Get

Get information about a specific SSO connector.

<params-table :params="[{"name":"accountId","type":"string","required":true,"description":"Account identifier."},{"name":"ssoConnectorId","type":"string","required":true,"description":"SSO Connector identifier."}]">



</params-table>

```php [php]
$response = $client->iam()->sso()->get('ACCOUNT_ID', 'SSO_CONNECTOR_ID');
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/operations/get-sso-connector">

View this operation on the Cloudflare API Reference

</callout>

## Update

Updates the state or configuration of an SSO connector.

<params-table :params="[{"name":"accountId","type":"string","required":true,"description":"Account identifier."},{"name":"ssoConnectorId","type":"string","required":true,"description":"SSO Connector identifier."},{"name":"values","type":"array","required":false,"description":"SSO Connector values, e.g. enabled, use_fedramp_language.","default":"[]"}]">



</params-table>

```php [php]
$response = $client->iam()->sso()->update('ACCOUNT_ID', 'SSO_CONNECTOR_ID', []);
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/operations/update-sso-connector-state">

View this operation on the Cloudflare API Reference

</callout>

## Delete

Deletes an SSO connector.

<params-table :params="[{"name":"accountId","type":"string","required":true,"description":"Account identifier."},{"name":"ssoConnectorId","type":"string","required":true,"description":"SSO Connector identifier."}]">



</params-table>

```php [php]
$response = $client->iam()->sso()->delete('ACCOUNT_ID', 'SSO_CONNECTOR_ID');
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/operations/delete-sso-connector">

View this operation on the Cloudflare API Reference

</callout>

## Begin Verification

Begin the verification process for an SSO connector.

<params-table :params="[{"name":"accountId","type":"string","required":true,"description":"Account identifier."},{"name":"ssoConnectorId","type":"string","required":true,"description":"SSO Connector identifier."}]">



</params-table>

```php [php]
$response = $client->iam()->sso()->beginVerification('ACCOUNT_ID', 'SSO_CONNECTOR_ID');
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/operations/begin-sso-connector-verification">

View this operation on the Cloudflare API Reference

</callout>
