<?php

/**
 * Distills Cloudflare's published OpenAPI schema into bin/cloudflare-api-schema.php,
 * the snapshot the coverage page is measured against.
 *
 * The schema itself is ~24MB, far too large to vendor, and downloading it on every
 * docs build would put the network in the way of generating documentation. So this
 * script is run by hand when the coverage page should be re-measured, and keeps only
 * what the matrix needs: each operation as `METHOD /normalised/path` with whether
 * Cloudflare marks it deprecated, plus the address of its page in Cloudflare's API
 * reference so bin/generate-doc-links.php can write `@link` tags that resolve.
 *
 * Usage: php bin/refresh-cloudflare-schema.php [path-or-url-to-openapi.json]
 */

const SCHEMA_URL = 'https://raw.githubusercontent.com/cloudflare/api-schemas/main/openapi.json';

const HTTP_METHODS = ['get', 'post', 'put', 'patch', 'delete', 'head'];

const DOCS_BASE = 'https://developers.cloudflare.com/api/resources/';

const SDK_RAW_BASE = 'https://raw.githubusercontent.com/cloudflare/cloudflare-typescript/main/';

/**
 * Convert a TypeScript SDK identifier to the spelling the docs site uses.
 */
function snake(string $name): string
{
    $name = preg_replace('/(?<=[a-z0-9])(?=[A-Z])/', '_', $name);
    $name = preg_replace('/(?<=[A-Z])(?=[A-Z][a-z])/', '_', (string) $name);

    return str_replace('-', '_', strtolower((string) $name));
}

/**
 * Map every operation to its page in Cloudflare's API reference.
 *
 * The reference site and the TypeScript SDK are generated together, so the
 * SDK's own `api.md` files are what say where a page lives. Each entry pairs
 * the HTTP route with the accessor chain — `client.d1.database.list` for
 * `get /accounts/{account_id}/d1/database` — and the page sits at that chain,
 * one `subresources/` hop per step.
 *
 * The schema's `x-fern-sdk-group-name` looks like it would do the same job and
 * quietly does not: it groups D1 under `d1` where the reference has
 * `d1/subresources/database`, and every such disagreement produces a link that
 * 404s.
 *
 * @return array<string, string> operation => url
 */
function docsFromSdk(): array
{
    $index = @file_get_contents(SDK_RAW_BASE . 'api.md');

    if ($index === false) {
        fwrite(STDERR, "Could not read the TypeScript SDK index; documentation addresses will be left out.\n");
        return [];
    }

    preg_match_all('~\]\((src/resources/[^)]*api\.md)\)~', $index, $matches);

    $docs = [];

    foreach ($matches[1] as $file) {

        $contents = @file_get_contents(SDK_RAW_BASE . $file);

        if ($contents === false) {
            fwrite(STDERR, "  skipped {$file}\n");
            continue;
        }

        preg_match_all(
            '~<code title="(get|post|put|patch|delete) ([^"]+)">client\.([A-Za-z0-9_.]+)\.<a[^>]*>([A-Za-z0-9_]+)</a>~',
            $contents,
            $entries,
            PREG_SET_ORDER
        );

        foreach ($entries as [, $method, $route, $accessors, $function]) {

            $segments = array_map('snake', explode('.', $accessors));

            $url = DOCS_BASE . array_shift($segments);

            foreach ($segments as $segment) {
                $url .= '/subresources/' . $segment;
            }

            $url .= '/methods/' . snake($function) . '/';

            // A route the SDK writes once for both scopes is two operations here.
            $routes = str_contains($route, '{accounts_or_zones}')
                ? [
                    str_replace('{accounts_or_zones}', 'accounts', $route),
                    str_replace('{accounts_or_zones}', 'zones', $route),
                ]
                : [$route];

            foreach ($routes as $one) {
                $key = strtoupper($method) . ' ' . preg_replace('/\{[^}]+\}/', '{}', $one);
                $docs[$key] ??= $url;
            }
        }
    }

    return $docs;
}

$source = $argv[1] ?? SCHEMA_URL;
$outFile = __DIR__ . '/cloudflare-api-schema.php';

fwrite(STDERR, "Reading {$source}\n");

$raw = @file_get_contents($source);

if ($raw === false) {
    fwrite(STDERR, "Could not read the schema from {$source}\n");
    exit(1);
}

$spec = json_decode($raw, true);

if (!is_array($spec) || !isset($spec['paths'])) {
    fwrite(STDERR, "That does not look like an OpenAPI document: no paths.\n");
    exit(1);
}

fwrite(STDERR, "Reading the TypeScript SDK for documentation addresses\n");

$sdkDocs = docsFromSdk();

$operations = [];
$docs = [];

foreach ($spec['paths'] as $path => $item) {

    // Parameter names carry no meaning for matching, only their position does.
    $normalised = preg_replace('/\{[^}]+\}/', '{}', (string) $path);

    foreach ($item as $method => $operation) {

        if (!in_array(strtolower((string) $method), HTTP_METHODS, true)) {
            continue;
        }

        $key = strtoupper((string) $method) . ' ' . $normalised;

        $operations[$key] = (bool) ($operation['deprecated'] ?? false);

        if (isset($sdkDocs[$key])) {
            $docs[$key] = $sdkDocs[$key];
        }
    }
}

ksort($operations);
ksort($docs);

$deprecated = count(array_filter($operations));

$lines = [];
$lines[] = '<?php';
$lines[] = '';
$lines[] = '/**';
$lines[] = " * Cloudflare's OpenAPI schema, distilled to the operations it documents.";
$lines[] = ' *';
$lines[] = ' * Generated by bin/refresh-cloudflare-schema.php from';
$lines[] = ' * ' . SCHEMA_URL;
$lines[] = ' *';
$lines[] = ' * Each key is an operation as `METHOD /path`, with path parameters reduced to';
$lines[] = ' * `{}` so they match however this package happens to name them. In `operations`';
$lines[] = ' * the value is whether Cloudflare marks the operation deprecated; in `docs` it is';
$lines[] = " * the operation's page in Cloudflare's API reference, read from the TypeScript";
$lines[] = ' * SDK the reference site is generated alongside.';
$lines[] = ' *';
$lines[] = sprintf(
    ' * %d operations, %d of them deprecated, %d with a documentation page.',
    count($operations),
    $deprecated,
    count($docs)
);
$lines[] = ' */';
$lines[] = '';
$lines[] = 'return [';
$lines[] = sprintf("    'version' => %s,", var_export((string) ($spec['info']['version'] ?? 'unknown'), true));
$lines[] = sprintf("    'refreshed' => %s,", var_export(date('Y-m-d'), true));
$lines[] = "    'operations' => [";

foreach ($operations as $operation => $isDeprecated) {
    $lines[] = sprintf("        %s => %s,", var_export($operation, true), $isDeprecated ? 'true' : 'false');
}

$lines[] = '    ],';
$lines[] = "    'docs' => [";

foreach ($docs as $operation => $url) {
    $lines[] = sprintf("        %s => %s,", var_export($operation, true), var_export($url, true));
}

$lines[] = '    ],';
$lines[] = '];';
$lines[] = '';

file_put_contents($outFile, implode("\n", $lines));

printf(
    "Wrote %s: %d operations, %d deprecated, %d documented, schema version %s.\n",
    realpath($outFile) ?: $outFile,
    count($operations),
    $deprecated,
    count($docs),
    $spec['info']['version'] ?? 'unknown'
);
