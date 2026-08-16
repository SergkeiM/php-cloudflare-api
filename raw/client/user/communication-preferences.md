# Communication Preferences

> What Cloudflare is allowed to email the authenticated user about, and in which language.

What Cloudflare is allowed to email the authenticated user about, and in
which language.

## Get

Get the communication preferences of the authenticated user.

Includes email verification status, marketing opt-in state and the
language locale.

```php [php]
$response = $client->user()->communicationPreferences()->get();
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/resources/user/">

View this operation on the Cloudflare API Reference

</callout>

## Update

Update the communication preferences of the authenticated user.

Only the preferences named are changed, and email verification settings
are not touched by this endpoint at all.

```php
$client->user()->communicationPreferences()->update([
    'preferences' => ['marketing' => true],
    'language-locale' => 'en-US',
]);
```

<params-table :params="[{"name":"values","type":"array","required":true,"description":"`preferences`, a map of preference key to subscription state, and `language-locale`, one of `en-US`, `es-ES`, `de-DE`, `fr-FR`, `it-IT`, `ja-JP`, `ko-KR`, `pt-BR`, `zh-CN` or `zh-TW`. Omitting the locale leaves it unchanged."}]">



</params-table>

```php [php]
$response = $client->user()->communicationPreferences()->update([]);
```

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/api/resources/user/">

View this operation on the Cloudflare API Reference

</callout>
