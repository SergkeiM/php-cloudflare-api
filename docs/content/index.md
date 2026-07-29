---
seo:
  title: PHP Client for Cloudflare API
  description: A simple Object Oriented PHP Client for the Cloudflare API. This package provides convenient access to the Cloudflare REST API using PHP.
---

::u-page-hero{class="dark:bg-gradient-to-b from-neutral-900 to-neutral-950"}
---
orientation: horizontal
---
#top
:hero-background

#title
The [PHP]{.text-primary} client for the [Cloudflare API]{.text-primary}.

#description
A simple, Object Oriented PHP client that provides convenient access to the Cloudflare REST API — accounts, zones, DNS, load balancers, R2, Workers, and more. Extensively documented, lazily loaded, and built for Laravel too.

#links
  :::u-button
  ---
  to: /getting-started
  size: xl
  trailing-icon: i-lucide-arrow-right
  ---
  Get started
  :::

  :::u-button
  ---
  icon: i-simple-icons-github
  color: neutral
  variant: outline
  size: xl
  to: https://github.com/SergkeiM/php-cloudflare-api
  target: _blank
  ---
  Open on GitHub
  :::

#default

  ```php [index.php]
  use Cloudflare\Client;

  $client = new Client('CLOUDFLARE_TOKEN');

  $response = $client->loadBalancers()->list(zoneId: 'zone_id');

  $balancers = $response->json('result');
  ```
::
