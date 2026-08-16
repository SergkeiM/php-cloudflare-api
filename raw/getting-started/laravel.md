# Laravel

> The Laravel integration ships inside sergkeim/php-cloudflare-api.

The Laravel integration ships inside `sergkeim/php-cloudflare-api`.

Once installed, if you are not using automatic package discovery, then you need to register the `Cloudflare\CloudflareServiceProvider` service provider in your `config/app.php`.

You can also optionally alias our facade:

```php [php]
'Cloudflare' => Cloudflare\Facades\Cloudflare::class,
```

## Configuration

Laravel Cloudflare requires connection configuration.

To get started, you'll need to publish all vendor assets:

```bash [bash]
php artisan vendor:publish
```

This will create a `config/cloudflare.php` file in your app that you can modify to set your configuration. Also, make sure you check for changes to the original config file in this package between releases.

Every key maps onto a [`ClientOptions`](/getting-started/usage#configuration) value and can be driven from your `.env`:

```ini [.env]
CLOUDFLARE_TOKEN=your-token
CLOUDFLARE_TIMEOUT=120
CLOUDFLARE_CONNECT_TIMEOUT=10
CLOUDFLARE_MAX_RETRIES=2
CLOUDFLARE_BASE_URL=
```

### Credentials

The API token lives under the `auth` key:

```php [config/cloudflare.php]
'auth' => [

    'token' => env('CLOUDFLARE_TOKEN'),

],
```

<table>
<thead>
  <tr>
    <th>
      Config key
    </th>
    
    <th>
      Environment variable
    </th>
  </tr>
</thead>

<tbody>
  <tr>
    <td>
      <code>
        auth.token
      </code>
    </td>
    
    <td>
      <code>
        CLOUDFLARE_TOKEN
      </code>
    </td>
  </tr>
</tbody>
</table>

A token must be configured, or resolving the client throws `Cloudflare\Exceptions\ConfigurationException`. Blank values count as unset.

### Transport

<table>
<thead>
  <tr>
    <th>
      Config key
    </th>
    
    <th>
      Environment variable
    </th>
    
    <th>
      <code>
        ClientOptions
      </code>
    </th>
  </tr>
</thead>

<tbody>
  <tr>
    <td>
      <code>
        base_url
      </code>
    </td>
    
    <td>
      <code>
        CLOUDFLARE_BASE_URL
      </code>
    </td>
    
    <td>
      <code>
        baseUrl
      </code>
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
        CLOUDFLARE_TIMEOUT
      </code>
    </td>
    
    <td>
      <code>
        timeout
      </code>
    </td>
  </tr>
  
  <tr>
    <td>
      <code>
        connect_timeout
      </code>
    </td>
    
    <td>
      <code>
        CLOUDFLARE_CONNECT_TIMEOUT
      </code>
    </td>
    
    <td>
      <code>
        connectTimeout
      </code>
    </td>
  </tr>
  
  <tr>
    <td>
      <code>
        max_retries
      </code>
    </td>
    
    <td>
      <code>
        CLOUDFLARE_MAX_RETRIES
      </code>
    </td>
    
    <td>
      <code>
        maxRetries
      </code>
    </td>
  </tr>
  
  <tr>
    <td>
      <code>
        headers
      </code>
    </td>
    
    <td>
      —
    </td>
    
    <td>
      <code>
        headers
      </code>
    </td>
  </tr>
</tbody>
</table>

## Usage

##### CloudflareManager

`Cloudflare\Client` is bound to the ioc container as `'cloudflare'` and can be accessed using the `Facades\Cloudflare` facade.

##### Facades\Cloudflare

This facade will dynamically pass static method calls to the `'cloudflare'` object in the ioc container which by default is the `Cloudflare\Client` class.

##### CloudflareServiceProvider

This class contains no public methods of interest. This class should be added to the providers array in `config/app.php`. This class will setup ioc bindings.

Here you can see an example of just how simple this package is to use. Out of the box. After you enter your `token` in the config file, it will just work:

```php [php]
use Cloudflare\Facades\Cloudflare;
// you can alias this in config/app.php if you like

Cloudflare::accounts()->list();

// or

Cloudflare::accounts()->get('ACCOUNT_ID');
```

If you prefer to use dependency injection over facades, then you can easily inject the manager like so:

```php [php]
use Cloudflare\Client;

class Foo
{

    public function __construct(
        private Client $cloudflare
    ) {

    }

    public function bar()
    {
        $this->cloudflare->accounts()->get('ACCOUNT_ID');
    }
}

app(Foo::class)->bar();
```
