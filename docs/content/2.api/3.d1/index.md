---
title: Cloudflare D1
description: Cloudflare D1
navigation:
    title: D1
---

# Cloudflare D1

D1 is Cloudflare’s native serverless database. D1 allows you to build applications that handle large amounts of users at no extra cost. With D1, you can restore your database to any minute within the last 30 days.

:button-link[Cloudflare API docs]{icon="heroicons-outline:external-link" href="https://developers.cloudflare.com/api/operations/cloudflare-d1-list-databases" blank}

## List

Returns a list of D1 databases.

```php [php]
$response = $client->d1()->list('ACCOUNT_ID');
```

## Create

Returns the created D1 database.

```php [php]

$response = $client->d1()->create('ACCOUNT_ID', 'name', 'location');
```

## Details

Returns the specified D1 database.

```php [php]
$response = $client->d1()->details('ACCOUNT_ID', 'DATABASE_ID');
```

## Delete

Deletes the specified D1 database.

```php [php]
$response = $client->d1()->delete('ACCOUNT_ID', 'DATABASE_ID');
```

## Export

Returns a URL where the SQL contents of your D1 can be downloaded. Note: this process may take some time for larger DBs, during which your D1 will be unavailable to serve queries. To avoid blocking your DB unnecessarily, an in-progress export must be continually polled or will automatically cancel.

```php [php]
$response = $client->d1()->export('ACCOUNT_ID', 'DATABASE_ID');
```

## Import

Generates a temporary URL for uploading an SQL file to, then instructing the D1 to import it and polling it for status updates. Imports block the D1 for their duration.

```php [php]
$response = $client->d1()->import('ACCOUNT_ID', 'DATABASE_ID', 'init');
```

## Query

Returns the query result as an object.

```php [php]
$response = $client->d1()->query('ACCOUNT_ID', 'DATABASE_ID', 'SELECT * FROM myTable WHERE field = ? OR field = ?;', [
    "firstParam",
    "secondParam"
]);
```

## Query Raw

Returns the query result rows as arrays rather than objects. This is a performance-optimized version of the /query endpoint.

```php [php]
$response = $client->d1()->raw('ACCOUNT_ID', 'DATABASE_ID', 'SELECT * FROM myTable WHERE field = ? OR field = ?;', [
    "firstParam",
    "secondParam"
]);
```