# Usage

> 

## Client

```php [php]
<?php

use Cloudflare\Client;

$client = new Client('CLOUDFLARE_TOKEN');

$response = $client->accounts()->list();

$results = $response->json();
```

## Authentication

The first argument to `Cloudflare\Client` is an [API token](https://developers.cloudflare.com/fundamentals/api/get-started/create-token), sent as `Authorization: Bearer …`:

```php [php]
$client = new Client('CLOUDFLARE_TOKEN');
```

API tokens are the only scheme this client supports. Scope each token to the permissions it needs.

A blank token is rejected with `Cloudflare\Exceptions\InvalidArgumentException`, so a missing environment variable fails at construction rather than as a confusing `401` later.

<callout icon="i-heroicons-information-circle">

Cloudflare also accepts the legacy Global API key (`X-Auth-Email` + `X-Auth-Key`) and, until **30 September 2026**, Origin CA Service Keys (`X-Auth-User-Service-Key`). Neither is supported here — Cloudflare recommends tokens for everything, and [Service Key authentication is being removed](https://developers.cloudflare.com/fundamentals/api/reference/deprecations/). If you need a header-based scheme, add it yourself via [Guzzle middleware](#guzzle-middleware).

</callout>

The `Authorization` header is always applied over anything you pass in `headers`, so it cannot be shadowed by accident.

## Configuration

The second argument to `Cloudflare\Client` is an optional `Cloudflare\ClientOptions` instance. Every option has a default, so `new Client('CLOUDFLARE_TOKEN')` and `new Client('CLOUDFLARE_TOKEN', new ClientOptions())` behave identically.

```php [php]
<?php

use Cloudflare\Client;
use Cloudflare\ClientOptions;

$client = new Client('CLOUDFLARE_TOKEN', new ClientOptions(
    timeout: 120,
    headers: ['User-Agent' => 'my-app/1.0'],
));
```

<table>
<thead>
  <tr>
    <th>
      Option
    </th>
    
    <th>
      Type
    </th>
    
    <th>
      Default
    </th>
    
    <th>
      Description
    </th>
  </tr>
</thead>

<tbody>
  <tr>
    <td>
      <code>
        baseUrl
      </code>
    </td>
    
    <td>
      <code>
        string|null
      </code>
    </td>
    
    <td>
      <code>
        https://api.cloudflare.com/client/v4/
      </code>
    </td>
    
    <td>
      Base URL every request is resolved against. Must be an absolute <code>
        http(s)
      </code>
      
       URL. A trailing slash is added if missing.
    </td>
  </tr>
  
  <tr>
    <td>
      <code>
        timeout
      </code>
    </td>
    
    <td>
      <code>
        float
      </code>
    </td>
    
    <td>
      <code>
        30
      </code>
    </td>
    
    <td>
      Seconds to wait for a response. <code>
        0
      </code>
      
       disables the timeout.
    </td>
  </tr>
  
  <tr>
    <td>
      <code>
        connectTimeout
      </code>
    </td>
    
    <td>
      <code>
        float
      </code>
    </td>
    
    <td>
      <code>
        10
      </code>
    </td>
    
    <td>
      Seconds to wait while connecting. <code>
        0
      </code>
      
       disables the timeout.
    </td>
  </tr>
  
  <tr>
    <td>
      <code>
        headers
      </code>
    </td>
    
    <td>
      <code>
        array
      </code>
    </td>
    
    <td>
      <code>
        []
      </code>
    </td>
    
    <td>
      Additional headers sent with every request.
    </td>
  </tr>
  
  <tr>
    <td>
      <code>
        middlewares
      </code>
    </td>
    
    <td>
      <code>
        array
      </code>
    </td>
    
    <td>
      <code>
        []
      </code>
    </td>
    
    <td>
      Guzzle middlewares, see <a href="#guzzle-middleware">
        below
      </a>
      
      .
    </td>
  </tr>
  
  <tr>
    <td>
      <code>
        maxRetries
      </code>
    </td>
    
    <td>
      <code>
        int
      </code>
    </td>
    
    <td>
      <code>
        2
      </code>
    </td>
    
    <td>
      Attempts made after the initial request, see <a href="#retries">
        Retries
      </a>
      
      . <code>
        0
      </code>
      
       disables retries.
    </td>
  </tr>
</tbody>
</table>

Invalid values throw `Cloudflare\Exceptions\InvalidArgumentException` at construction time.

The options a client was built with are available via `$client->getOptions()`.

<callout icon="i-heroicons-light-bulb">

Raise `timeout` when uploading large Worker scripts or running long D1 queries. Point `baseUrl` at a local mock server to test against this client without hitting Cloudflare.

</callout>

### Headers

Headers you supply are merged over the defaults, case-insensitively, so `user-agent` and `User-Agent` both replace the built-in `User-Agent` rather than adding a second one.

`Authorization` is owned by the client and always derived from the [token](#authentication) you pass to the constructor — supplying it in `headers` has no effect.

## Retries

Transient failures are retried automatically, twice by default.

A request is retried when the connection fails outright, or when Cloudflare answers with one of:

<table>
<thead>
  <tr>
    <th>
      Status
    </th>
    
    <th>
      
    </th>
  </tr>
</thead>

<tbody>
  <tr>
    <td>
      <code>
        408
      </code>
    </td>
    
    <td>
      Request Timeout
    </td>
  </tr>
  
  <tr>
    <td>
      <code>
        409
      </code>
    </td>
    
    <td>
      Conflict
    </td>
  </tr>
  
  <tr>
    <td>
      <code>
        429
      </code>
    </td>
    
    <td>
      Too Many Requests
    </td>
  </tr>
  
  <tr>
    <td>
      <code>
        5xx
      </code>
    </td>
    
    <td>
      Any server error
    </td>
  </tr>
</tbody>
</table>

Every other 4xx is a problem with the request itself and is surfaced immediately, without retrying.

Between attempts the client waits using exponential backoff with full jitter — a random delay up to 500ms before the first retry, doubling each time, capped at 8 seconds. When Cloudflare sends a `Retry-After` header (as it does on `429`), that value wins over the computed backoff. Both the seconds and the HTTP-date forms are understood.

```php [php]
use Cloudflare\Client;
use Cloudflare\ClientOptions;

// Be more persistent.
$client = new Client('CLOUDFLARE_TOKEN', new ClientOptions(maxRetries: 5));

// Turn retries off entirely.
$client = new Client('CLOUDFLARE_TOKEN', new ClientOptions(maxRetries: 0));
```

Once the attempts are exhausted, the last response is thrown as the usual [exception](#error-handling).

<callout icon="i-heroicons-exclamation-triangle" color="amber">

Retries apply to every HTTP method, including `POST`. A `429` is rejected before Cloudflare processes it, so resending is safe, but a `5xx` is ambiguous — the request may have been applied before the error was returned. If a write must never be duplicated, use `maxRetries: 0` for that client.

</callout>

Middlewares you register run on every attempt, not just the last one, so logging middleware sees the full picture.

## Response

Every call to an API returns an instance of `Cloudflare\HttpClient\Response`, which provides a variety of methods that may be used to inspect the response:

```php [php]
$response->body() : string;
$response->json($key = null, $default = null) : mixed;
$response->status() : int;
$response->successful() : bool;
$response->failed() : bool;
$response->errors() : array;
$response->messages() : array;
$response->hasErrors() : bool;
$response->toPsrResponse() : \Psr\Http\Message\ResponseInterface;
```

`json()` accepts dot notation, so `$response->json('result.id')` reaches into the decoded body and returns `$default` if any segment is missing.

### Status

`successful()` is true for **any 2xx status**, and `failed()` is its inverse. Cloudflare answers most endpoints with `200`, but some return `201`, `202` or `204` — and a `HEAD` request commonly has no body at all. On a `204` the body is empty, so `json()` returns `null`; check `successful()` rather than the decoded payload for those.

### Envelope errors

A non-2xx status raises an [exception](#error-handling), so you rarely inspect failures by hand. The case that *does* need checking is the opposite one: Cloudflare answers some operations with a **2xx status and a body carrying "success": false**, notably where part of a bulk request failed. The status is fine, but the operation was not.

`errors()` and `messages()` read those lists straight off the envelope, and `hasErrors()` is the shorthand:

```php [php]
$response = $client->dns()->import('ZONE_ID', $bindFile);

if ($response->hasErrors()) {
    foreach ($response->errors() as $error) {
        // ['code' => 1003, 'message' => 'Invalid identifier']
        logger()->warning($error['message'], $error);
    }
}
```

Both return an empty array when the envelope has no such list, so they are safe to call on any response, including an empty `204`.

## Pagination

List endpoints answer with one page of results and describe the rest in the `result_info` envelope. `$client->paginate()` walks those pages for you and hands back every entry as a single iterator:

```php [php]
<?php

use Cloudflare\Client;

$client = new Client('CLOUDFLARE_TOKEN');

$zones = $client->paginate(
    fn (array $params) => $client->zones()->list('ACCOUNT_ID', $params),
    ['per_page' => 100]
);

foreach ($zones as $zone) {
    echo $zone['name'];
}
```

The first argument is a callable that fetches one page: it receives the query parameters for that page and returns the response. Every list method takes its query parameters as the last argument, so any of them fits the same shape — `fn (array $params) => $client->dns()->list('ZONE_ID', $params)`, and so on.

The second argument is the query parameters to start from. They are sent with the first page and carried over to every page after it, so filters and `per_page` apply throughout. Cloudflare's default page size is small and its maximum varies per endpoint, so passing `per_page` is usually worth it.

Pages are requested as they are consumed. Nothing is sent until the loop starts, and `break` stops the requests along with the iteration — so paging through a large zone costs only the pages you actually read.

### Page by page

`pages()` yields the responses instead of their entries, for when a whole page is the unit of work or the envelope is needed alongside the results:

```php [php]
foreach ($client->paginate(fn (array $params) => $client->dns()->list('ZONE_ID', $params))->pages() as $page) {
    Record::insert($page->json('result'));
}
```

`all()` is the opposite trade: it collects everything into one array. Convenient for small lists, but it holds the whole collection in memory and cannot be interrupted.

```php [php]
$records = $client->paginate(fn (array $params) => $client->dns()->list('ZONE_ID', $params))->all();
```

### How the next page is found

Both schemes Cloudflare uses are handled, picked from whatever the response reports:

<table>
<thead>
  <tr>
    <th>
      Envelope
    </th>
    
    <th>
      Next page
    </th>
  </tr>
</thead>

<tbody>
  <tr>
    <td>
      <code>
        result_info.cursors.after
      </code>
      
       or <code>
        result_info.cursor
      </code>
    </td>
    
    <td>
      Sent as <code>
        cursor
      </code>
      
      , as R2 and Workers KV expect. Takes precedence when present.
    </td>
  </tr>
  
  <tr>
    <td>
      <code>
        result_info.total_pages
      </code>
      
      , or <code>
        total_count
      </code>
      
       with <code>
        per_page
      </code>
    </td>
    
    <td>
      Sent as <code>
        page
      </code>
      
      , until the last page is reached.
    </td>
  </tr>
  
  <tr>
    <td>
      <code>
        per_page
      </code>
      
       only
    </td>
    
    <td>
      Sent as <code>
        page
      </code>
      
      , until a page comes back shorter than <code>
        per_page
      </code>
      
      .
    </td>
  </tr>
  
  <tr>
    <td>
      No <code>
        result_info
      </code>
    </td>
    
    <td>
      Treated as a single page.
    </td>
  </tr>
</tbody>
</table>

Iteration also stops on an empty page, and on a cursor that points back at the page just read, so a truncated or repetitive envelope cannot spin forever.

An endpoint whose `result` is not a list — a single object, as `zones()->get()` returns — throws `Cloudflare\Exceptions\InvalidArgumentException`, since there is nothing to page through. [Errors](#error-handling) from any page surface as usual, at the point the loop reaches it.

<callout icon="i-heroicons-light-bulb">

For an endpoint this package does not wrap yet, `$client->getHttpClient()->paginate('/some/path', ['per_page' => 100])` pages a raw path the same way. See [custom requests](#making-customundocumented-requests).

</callout>

## Error Handling

When the client is unable to connect to the API `Cloudflare\HttpClient\Exceptions\ConnectionException` will be thrown.

If the API returns a non-2xx status code, a subclass of `Cloudflare\HttpClient\Exceptions\RequestException` will be thrown:

<table>
<thead>
  <tr>
    <th>
      Status Code
    </th>
    
    <th>
      Error Type
    </th>
  </tr>
</thead>

<tbody>
  <tr>
    <td>
      400
    </td>
    
    <td>
      <code>
        BadRequestException
      </code>
    </td>
  </tr>
  
  <tr>
    <td>
      401
    </td>
    
    <td>
      <code>
        AuthenticationException
      </code>
    </td>
  </tr>
  
  <tr>
    <td>
      403
    </td>
    
    <td>
      <code>
        PermissionDeniedException
      </code>
    </td>
  </tr>
  
  <tr>
    <td>
      404
    </td>
    
    <td>
      <code>
        NotFoundException
      </code>
    </td>
  </tr>
  
  <tr>
    <td>
      422
    </td>
    
    <td>
      <code>
        UnprocessableEntityException
      </code>
    </td>
  </tr>
  
  <tr>
    <td>
      429
    </td>
    
    <td>
      <code>
        RateLimitException
      </code>
    </td>
  </tr>
  
  <tr>
    <td>
      >=500
    </td>
    
    <td>
      <code>
        InternalServerException
      </code>
    </td>
  </tr>
  
  <tr>
    <td>
      N/A
    </td>
    
    <td>
      <code>
        RequestException
      </code>
    </td>
  </tr>
</tbody>
</table>

The `Cloudflare\HttpClient\Exceptions\RequestException` instance has a public $response property which will allow you to inspect the returned response.

### Catching everything

Every exception this package throws implements `Cloudflare\Contracts\ExceptionInterface`, so you can handle anything originating from the client with a single catch block:

```php [php]
<?php

use Cloudflare\Contracts\ExceptionInterface;

try {
    $response = $client->zones()->get('ZONE_ID');
} catch (ExceptionInterface $e) {
    // Any failure from this package: a bad request, a missing argument,
    // a connection problem, a misconfiguration.
    report($e);
}
```

That covers both families of exception:

<table>
<thead>
  <tr>
    <th>
      Namespace
    </th>
    
    <th>
      Thrown when
    </th>
  </tr>
</thead>

<tbody>
  <tr>
    <td>
      <code>
        Cloudflare\HttpClient\Exceptions\*
      </code>
    </td>
    
    <td>
      The request reached the transport: a connection failure, or an error response.
    </td>
  </tr>
  
  <tr>
    <td>
      <code>
        Cloudflare\Exceptions\*
      </code>
    </td>
    
    <td>
      The call never left your process: a missing or invalid argument, an unknown endpoint, a bad configuration.
    </td>
  </tr>
</tbody>
</table>

The individual exceptions keep their native parents — `Cloudflare\Exceptions\InvalidArgumentException` still extends `\InvalidArgumentException` — so catching the SPL types works as before, and the interface is purely additive.

## Guzzle Middleware

Since PHP Client for Cloudflare API is powered by Guzzle, you may take advantage of [Guzzle Middleware](https://docs.guzzlephp.org/en/stable/handlers-and-middleware.html) to manipulate the outgoing request or inspect the incoming response.

```php [php]
<?php

use Cloudflare\Client;
use Cloudflare\ClientOptions;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

$middlewares = [
    function (callable $handler) {
        return function (
            RequestInterface $request,
            array $options
        ) use ($handler) {
            $promise = $handler($request, $options);
            return $promise->then(
                function (ResponseInterface $response) {
                    $header = $response->getHeader('X-Example');
                    // ...
                    return $response;
                }
            );
        };
    }
];

$client = new Client('CLOUDFLARE_TOKEN', new ClientOptions(middlewares: $middlewares));

$response = $client->accounts()->list();

$results = $response->json();
```

## Making custom/undocumented requests

This package provides convenient access to the Cloudflare REST API. If you need to access undocumented endpoints, the package can still be used.

```php [php]
<?php

use Cloudflare\Client;

$client = new Client('CLOUDFLARE_TOKEN');

$response = $client->getHttpClient()->get('/some/path', [
    'some_query_arg' => 'bar'
]);

$results = $response->json();
```

If the path is a list endpoint, `paginate()` walks it exactly like the [wrapped ones](#pagination):

```php [php]
foreach ($client->getHttpClient()->paginate('/some/path', ['per_page' => 100]) as $result) {
    // ...
}
```
