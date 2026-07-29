# Page Rule

> A fluent configuration helper for building Page Rule payloads.

## Usage

Cloudflare API provides extensive configuration for Page Rules, this helper aims to simplify it. Construct it with the target URL pattern, then chain one setting method per action you want the rule to apply (`cacheLevel()`, `alwaysUseHTTPS()`, `disableZaraz()`, and so on) instead of building the raw `targets`/`actions` array by hand.

```php [php]
use Cloudflare\Configurations\Zones\PageRule;

$pageRule = new PageRule('example.com/*');

$pageRule
    ->enable()
    ->cacheLevel('simplified')
    ->disableZaraz(true);

$response = $client->pageRules()->create('zone_id', $pageRule);
```
