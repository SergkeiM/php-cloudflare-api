# Rules

> The rule classes that make up a ruleset, and how to configure each action.

## Usage

A ruleset is a list of rules, and each rule pairs an **expression** — which traffic it matches — with an **action** — what Cloudflare does about it. This package ships one class per action, so the action name is picked by the class you construct rather than by a string you have to remember.

```php [php]
use Cloudflare\Configurations\Ruleset;
use Cloudflare\Configurations\Rules\ManagedChallengeRule;

$rule = (new ManagedChallengeRule())
    ->enable()
    ->setDescription('Challenge logins from outside the office')
    ->setExpression('http.request.uri.path eq "/login" and ip.src ne 203.0.113.4');

$ruleset = (new Ruleset('Login protection'))
    ->zone()
    ->requestFirewallCustom()
    ->addRule($rule);

$response = $client->rulesets()->create(zoneId: 'zone_id', values: $ruleset);
```

`addRule()` takes a rule object. If you would rather hand-write the whole payload, skip these classes and pass a plain array to `$client->rulesets()->create()` instead — it accepts either.

## Every rule shares these

<table>
<thead>
  <tr>
    <th>
      Method
    </th>
    
    <th>
      Effect
    </th>
  </tr>
</thead>

<tbody>
  <tr>
    <td>
      <code>
        enable()
      </code>
      
       / <code>
        disable()
      </code>
    </td>
    
    <td>
      Whether Cloudflare runs the rule. Rules are <strong>
        disabled
      </strong>
      
       until you call <code>
        enable()
      </code>
      
      .
    </td>
  </tr>
  
  <tr>
    <td>
      <code>
        setExpression($expression)
      </code>
    </td>
    
    <td>
      Which traffic matches. Takes a string, an <a href="/advanced/expression-builder">
        Expression Builder
      </a>
      
      , or a closure that receives one. Matches everything when unset.
    </td>
  </tr>
  
  <tr>
    <td>
      <code>
        setDescription($description)
      </code>
    </td>
    
    <td>
      An informative description of the rule.
    </td>
  </tr>
  
  <tr>
    <td>
      <code>
        setLogging($enabled)
      </code>
    </td>
    
    <td>
      Whether Cloudflare logs when the rule matches.
    </td>
  </tr>
  
  <tr>
    <td>
      <code>
        setActionParameters($parameters)
      </code>
    </td>
    
    <td>
      Parameters for the rule's action, merged over whatever the class builds. Calling it twice merges rather than replaces.
    </td>
  </tr>
  
  <tr>
    <td>
      <code>
        setId($id)
      </code>
      
       / <code>
        setRef($reference)
      </code>
    </td>
    
    <td>
      Identify an existing rule, for updates.
    </td>
  </tr>
</tbody>
</table>

Expressions read well as a closure:

```php [php]
use Cloudflare\Configurations\Rules\BlockRule;

$rule = (new BlockRule('{"error":"blocked"}'))
    ->enable()
    ->setExpression(fn ($builder) => $builder->field('ip.src')->eq('203.0.113.4'));
```

## The rules

Cloudflare defines a different set of parameters for each action. Where it requires them, the class asks for them in its constructor; where they are optional, pass them with `setActionParameters()`.

<table>
<thead>
  <tr>
    <th>
      Class
    </th>
    
    <th>
      Cloudflare action
    </th>
    
    <th>
      Parameters
    </th>
  </tr>
</thead>

<tbody>
  <tr>
    <td>
      <code>
        BlockRule
      </code>
    </td>
    
    <td>
      <code>
        block
      </code>
    </td>
    
    <td>
      <code>
        $content
      </code>
      
      , <code>
        $contentType
      </code>
      
      , <code>
        $statusCode
      </code>
    </td>
  </tr>
  
  <tr>
    <td>
      <code>
        ChallengeRule
      </code>
    </td>
    
    <td>
      <code>
        challenge
      </code>
    </td>
    
    <td>
      none
    </td>
  </tr>
  
  <tr>
    <td>
      <code>
        JSChallengeRule
      </code>
    </td>
    
    <td>
      <code>
        js_challenge
      </code>
    </td>
    
    <td>
      none
    </td>
  </tr>
  
  <tr>
    <td>
      <code>
        ManagedChallengeRule
      </code>
    </td>
    
    <td>
      <code>
        managed_challenge
      </code>
    </td>
    
    <td>
      none
    </td>
  </tr>
  
  <tr>
    <td>
      <code>
        LogRule
      </code>
    </td>
    
    <td>
      <code>
        log
      </code>
    </td>
    
    <td>
      none
    </td>
  </tr>
  
  <tr>
    <td>
      <code>
        DDoSDynamicRule
      </code>
    </td>
    
    <td>
      <code>
        ddos_dynamic
      </code>
    </td>
    
    <td>
      none
    </td>
  </tr>
  
  <tr>
    <td>
      <code>
        ForceConnectionCloseRule
      </code>
    </td>
    
    <td>
      <code>
        force_connection_close
      </code>
    </td>
    
    <td>
      none
    </td>
  </tr>
  
  <tr>
    <td>
      <code>
        ExecuteRule
      </code>
    </td>
    
    <td>
      <code>
        execute
      </code>
    </td>
    
    <td>
      <code>
        $rulesetId
      </code>
      
      , plus optional <code>
        overrides
      </code>
      
       and <code>
        matched_data
      </code>
    </td>
  </tr>
  
  <tr>
    <td>
      <code>
        ScoreRule
      </code>
    </td>
    
    <td>
      <code>
        score
      </code>
    </td>
    
    <td>
      <code>
        $increment
      </code>
    </td>
  </tr>
  
  <tr>
    <td>
      <code>
        ServeErrorRule
      </code>
    </td>
    
    <td>
      <code>
        serve_error
      </code>
    </td>
    
    <td>
      <code>
        $contentType
      </code>
      
      , <code>
        $content
      </code>
      
      , <code>
        $statusCode
      </code>
    </td>
  </tr>
  
  <tr>
    <td>
      <code>
        CompressionRule
      </code>
    </td>
    
    <td>
      <code>
        compress_response
      </code>
    </td>
    
    <td>
      <code>
        $algorithm
      </code>
    </td>
  </tr>
  
  <tr>
    <td>
      <code>
        ConfigRule
      </code>
    </td>
    
    <td>
      <code>
        set_config
      </code>
    </td>
    
    <td>
      <code>
        $settings
      </code>
    </td>
  </tr>
  
  <tr>
    <td>
      <code>
        SkipRule
      </code>
    </td>
    
    <td>
      <code>
        skip
      </code>
    </td>
    
    <td>
      <code>
        $skip
      </code>
    </td>
  </tr>
  
  <tr>
    <td>
      <code>
        RedirectRule
      </code>
    </td>
    
    <td>
      <code>
        redirect
      </code>
    </td>
    
    <td>
      <code>
        from_value
      </code>
      
       or <code>
        from_list
      </code>
    </td>
  </tr>
  
  <tr>
    <td>
      <code>
        RewriteRule
      </code>
    </td>
    
    <td>
      <code>
        rewrite
      </code>
    </td>
    
    <td>
      <code>
        uri
      </code>
      
      , <code>
        headers
      </code>
    </td>
  </tr>
  
  <tr>
    <td>
      <code>
        OriginRule
      </code>
    </td>
    
    <td>
      <code>
        route
      </code>
    </td>
    
    <td>
      <code>
        origin
      </code>
      
      , <code>
        host_header
      </code>
      
      , <code>
        sni
      </code>
    </td>
  </tr>
  
  <tr>
    <td>
      <code>
        CacheSettingsRule
      </code>
    </td>
    
    <td>
      <code>
        set_cache_settings
      </code>
    </td>
    
    <td>
      <code>
        cache
      </code>
      
      , <code>
        edge_ttl
      </code>
      
      , <code>
        browser_ttl
      </code>
      
      , <code>
        cache_key
      </code>
      
      , and more
    </td>
  </tr>
  
  <tr>
    <td>
      <code>
        LogCustomFieldRule
      </code>
    </td>
    
    <td>
      <code>
        log_custom_field
      </code>
    </td>
    
    <td>
      <code>
        request_fields
      </code>
      
      , <code>
        response_fields
      </code>
      
      , <code>
        cookie_fields
      </code>
      
      , and more
    </td>
  </tr>
</tbody>
</table>

### Rules that take constructor arguments

```php [php]
use Cloudflare\Configurations\Rules\BlockRule;
use Cloudflare\Configurations\Rules\CompressionRule;
use Cloudflare\Configurations\Rules\ConfigRule;
use Cloudflare\Configurations\Rules\ExecuteRule;
use Cloudflare\Configurations\Rules\ScoreRule;
use Cloudflare\Configurations\Rules\ServeErrorRule;
use Cloudflare\Configurations\Rules\SkipRule;

// Answer the request yourself. `content` is sent as-is, so encode it to match
// the content type you declare.
new BlockRule('{"error":"blocked"}', 'application/json', 403);

// Run one of Cloudflare's managed rulesets.
new ExecuteRule('4814384a9e5d4991b9815dcfc25d2f1f');

// Add to the request's cumulative score.
new ScoreRule(20);

// Serve an error page instead of reaching the origin.
new ServeErrorRule('text/html', '<h1>Gone</h1>', 410);

// Compress the response with a named algorithm.
new CompressionRule('brotli');

// Change zone settings for this request only.
new ConfigRule(['ssl' => 'full', 'automatic_https_rewrites' => true]);

// Skip Cloudflare's own products or rules.
new SkipRule(['products' => ['waf', 'rateLimit']]);
```

### Everything else

The remaining actions take parameters Cloudflare defines per action and extends over time, so they are passed through as given rather than modelled one method at a time:

```php [php]
use Cloudflare\Configurations\Rules\RedirectRule;
use Cloudflare\Configurations\Rules\RewriteRule;

$redirect = (new RedirectRule())
    ->enable()
    ->setExpression('http.request.uri.path eq "/old"')
    ->setActionParameters([
        'from_value' => [
            'status_code' => 301,
            'target_url' => ['value' => 'https://example.com/new'],
            'preserve_query_string' => true,
        ],
    ]);

$rewrite = (new RewriteRule())
    ->enable()
    ->setActionParameters([
        'uri' => ['path' => ['value' => '/rewritten']],
        'headers' => ['x-source' => ['operation' => 'set', 'value' => 'cloudflare']],
    ]);
```

`setActionParameters()` works on every rule, including the ones with constructors, so anything Cloudflare adds is reachable without waiting for this package to catch up.

<callout icon="i-simple-icons-cloudflare" to="https://developers.cloudflare.com/ruleset-engine/rules-language/actions/">

The full list of actions and their parameters on the Cloudflare Rules language reference

</callout>
