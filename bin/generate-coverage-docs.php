<?php

/**
 * Builds docs/content/4.coverage.md: how much of the Cloudflare API this package
 * covers, measured against Cloudflare's own OpenAPI schema.
 *
 * Nothing here is asserted by hand. The operations this package implements are
 * read out of the endpoint classes — every request path in src/Endpoints is a
 * string literal — and matched against the schema snapshot in
 * bin/cloudflare-api-schema.php, refreshed by bin/refresh-cloudflare-schema.php.
 *
 * bin/cloudflare-api-names.php only supplies prettier labels for resources whose
 * path segment reads badly; it has no bearing on any number on the page.
 *
 * Usage: php bin/generate-coverage-docs.php
 */

require __DIR__ . '/../vendor/autoload.php';

$schema = require __DIR__ . '/cloudflare-api-schema.php';
$names = require __DIR__ . '/cloudflare-api-names.php';

$endpointsDir = __DIR__ . '/../src/Endpoints';
$clientFile = __DIR__ . '/../src/Client.php';
$outFile = __DIR__ . '/../docs/content/4.coverage.md';

const HTTP_METHODS = 'get|post|put|patch|delete|head';

/**
 * `/accounts/{}` and `/zones/{}` multiplex nearly the whole API, so the segment
 * after them is what actually names a resource.
 */
function resourceOf(string $operation): string
{
    [, $path] = explode(' ', $operation, 2);

    $segments = array_values(array_filter(
        explode('/', $path),
        // An API version in the path names nothing.
        fn (string $segment) => $segment !== '' && preg_match('/^v\d+$/', $segment) !== 1
    ));

    if (in_array($segments[0] ?? '', ['accounts', 'zones'], true) && ($segments[1] ?? '') === '{}' && isset($segments[2])) {
        return $segments[2];
    }

    return $segments[0] ?? '';
}

/**
 * Map every endpoint class to its documentation route by walking the client the
 * way bin/generate-client-docs.php does: pages are named after the accessor,
 * not the class, so `IP` lives at `/client/ips`.
 *
 * @return array<string, string> class => route
 */
function docRoutes(string $clientFile): array
{
    preg_match_all(
        "/'(\w+)'\s*=>\s*new Endpoints\\\\([\w\\\\]+)\(/",
        (string) file_get_contents($clientFile),
        $matches,
        PREG_SET_ORDER
    );

    $routes = [];
    $queue = [];

    foreach ($matches as $match) {
        $queue[] = ['Cloudflare\\Endpoints\\' . $match[2], '/client/' . kebab($match[1])];
    }

    while ($queue !== []) {

        [$class, $route] = array_shift($queue);

        if (isset($routes[$class])) {
            continue;
        }

        $routes[$class] = $route;

        $reflection = new ReflectionClass($class);

        foreach ($reflection->getMethods(ReflectionMethod::IS_PUBLIC) as $method) {

            if ($method->getDeclaringClass()->getName() !== $class || $method->isConstructor() || $method->isStatic()) {
                continue;
            }

            $returnType = $method->getReturnType();

            if ($returnType instanceof ReflectionNamedType && !$returnType->isBuiltin() && is_subclass_of($returnType->getName(), Cloudflare\Endpoints\AbstractEndpoint::class)) {
                $queue[] = [$returnType->getName(), $route . '/' . kebab($method->getName())];
            }
        }
    }

    return $routes;
}

/**
 * `loadBalancers` -> `load-balancers`, matching the generated client docs.
 */
function kebab(string $value): string
{
    $value = (string) preg_replace('/(?<=[a-z0-9])(?=[A-Z])/', '-', $value);
    $value = (string) preg_replace('/(?<=[A-Z])(?=[A-Z][a-z])/', '-', $value);

    return strtolower($value);
}

/**
 * The class a file under src/Endpoints declares, by PSR-4.
 */
function classOf(string $file): string
{
    $root = realpath(__DIR__ . '/../src') ?: '';
    $relative = trim(str_replace($root, '', realpath($file) ?: $file), '/');

    return 'Cloudflare\\' . str_replace('/', '\\', (string) preg_replace('/\.php$/', '', $relative));
}

/**
 * Resolve a `/client/...` route against the generated reference pages, so a
 * link this script emits cannot point at a page that is not there.
 */
function docRouteExists(string $route): bool
{
    $segments = array_values(array_filter(explode('/', trim($route, '/'))));

    if (array_shift($segments) !== 'client') {
        return false;
    }

    $directory = __DIR__ . '/../docs/content/2.client';

    while ($segments !== []) {

        $segment = array_shift($segments);

        // Pages carry an ordering prefix the route drops.
        $page = glob($directory . '/[0-9][0-9].' . $segment . '.md');
        $child = glob($directory . '/[0-9][0-9].' . $segment);

        if ($segments === [] && $page !== [] && $page !== false) {
            return true;
        }

        if ($child === [] || $child === false || !is_dir($child[0])) {
            return false;
        }

        $directory = $child[0];
    }

    return is_file($directory . '/00.index.md');
}

/**
 * Every request this package can issue, as `METHOD /path`, mapped to the
 * endpoint classes issuing it.
 *
 * @return array<string, array<string, true>> operation => [file => true]
 */
function implementedOperations(string $directory): array
{
    $operations = [];

    $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($directory));

    foreach ($files as $file) {

        if ($file->getExtension() !== 'php') {
            continue;
        }

        $source = (string) file_get_contents($file->getPathname());

        preg_match_all(
            '/getHttpClient\(\)\s*->\s*(' . HTTP_METHODS . ')\(\s*([\'"])(.+?)\2/s',
            $source,
            $matches,
            PREG_SET_ORDER
        );

        foreach ($matches as $match) {

            $method = strtoupper($match[1]);

            // A scoped endpoint serves both an account path and a zone path.
            $paths = str_contains($match[3], 'scopePath')
                ? [
                    preg_replace('/\{\$this->scopePath\([^}]*\)\}/', '/accounts/{}', $match[3]),
                    preg_replace('/\{\$this->scopePath\([^}]*\)\}/', '/zones/{}', $match[3]),
                ]
                : [$match[3]];

            foreach ($paths as $path) {
                $path = '/' . ltrim((string) preg_replace('/\{\$[^}]+\}/', '{}', (string) $path), '/');

                $operations[$method . ' ' . $path][$file->getPathname()] = true;
            }
        }
    }

    ksort($operations);

    return $operations;
}

// ---------------------------------------------------------------------
// 1. What this package implements, and what the schema documents.
// ---------------------------------------------------------------------

$implemented = implementedOperations($endpointsDir);

if ($implemented === []) {
    fwrite(STDERR, "Found no request paths in {$endpointsDir}\n");
    exit(1);
}

$routes = docRoutes($clientFile);
$schemaOperations = $schema['operations'];

/**
 * A parameterised path also covers the named siblings the schema spells out
 * beside it: implementing `GET /zones/{}/settings/{}` is what lets a caller
 * reach `GET /zones/{}/settings/always_use_https`.
 */
$covers = static function (string $operation) use ($implemented): bool {

    if (isset($implemented[$operation])) {
        return true;
    }

    [$method, $path] = explode(' ', $operation, 2);
    $segments = explode('/', $path);
    $last = array_pop($segments);

    if ($last === '{}' || $last === '') {
        return false;
    }

    return isset($implemented[$method . ' ' . implode('/', $segments) . '/{}']);
};

$covered = [];
$deprecatedInUse = [];

foreach ($schemaOperations as $operation => $isDeprecated) {

    if (!$covers($operation)) {
        continue;
    }

    $covered[$operation] = true;

    if ($isDeprecated && isset($implemented[$operation])) {
        $deprecatedInUse[$operation] = array_keys($implemented[$operation]);
    }
}

$unknown = array_diff_key($implemented, $schemaOperations);

// ---------------------------------------------------------------------
// 2. Group by resource.
// ---------------------------------------------------------------------

$resources = [];

foreach ($schemaOperations as $operation => $isDeprecated) {

    if ($isDeprecated) {
        continue;
    }

    $resource = resourceOf($operation);

    $resources[$resource]['total'] = ($resources[$resource]['total'] ?? 0) + 1;
    $resources[$resource]['covered'] = ($resources[$resource]['covered'] ?? 0) + (isset($covered[$operation]) ? 1 : 0);
    $resources[$resource]['endpoints'] ??= [];
}

foreach ($implemented as $operation => $files) {

    $resource = resourceOf($operation);

    if (!isset($resources[$resource])) {
        continue;
    }

    foreach (array_keys($files) as $file) {

        $class = classOf($file);
        $route = $routes[$class] ?? null;

        if ($route === null) {
            fwrite(STDERR, "{$class} issues requests but nothing on the client reaches it.\n");
            exit(1);
        }

        if (!docRouteExists($route)) {
            fwrite(STDERR, "No reference page at {$route} for {$class}. Run composer docs:generate-client first.\n");
            exit(1);
        }

        $resources[$resource]['endpoints'][$route] = true;
    }
}

$liveTotal = array_sum(array_column($resources, 'total'));
$liveCovered = array_sum(array_column($resources, 'covered'));

$coveredResources = array_filter($resources, fn (array $resource) => $resource['covered'] > 0);
$missingResources = array_filter($resources, fn (array $resource) => $resource['covered'] === 0);

uasort($coveredResources, fn (array $a, array $b) => [$b['covered'], $b['total']] <=> [$a['covered'], $a['total']]);
uasort($missingResources, fn (array $a, array $b) => $b['total'] <=> $a['total']);

/**
 * `load_balancers` -> `Load Balancers`, unless a nicer label is on file.
 */
$label = static function (string $resource) use ($names): string {
    return $names[$resource] ?? ucwords(str_replace(['_', '-'], ' ', $resource));
};

// ---------------------------------------------------------------------
// 3. Render.
// ---------------------------------------------------------------------

$lines = [];
$lines[] = '---';
$lines[] = 'title: Coverage';
$lines[] = 'description: "How much of the Cloudflare API this package covers, measured against Cloudflare\'s OpenAPI schema."';
$lines[] = 'navigation:';
$lines[] = '    title: Coverage';
$lines[] = '---';
$lines[] = '';
$lines[] = sprintf(
    'This package implements **%d of the %d operations** Cloudflare documents (**%d%%**), across **%d of its %d API resources**.',
    $liveCovered,
    $liveTotal,
    (int) round($liveCovered / max(1, $liveTotal) * 100),
    count($coveredResources),
    count($resources)
);
$lines[] = '';
$lines[] = sprintf(
    'Measured against Cloudflare\'s [published OpenAPI schema](https://github.com/cloudflare/api-schemas) — version %s, read %s — by matching every request path in this package against the paths the schema documents. The %d operations Cloudflare marks deprecated are left out of the counts below.',
    $schema['version'],
    $schema['refreshed'],
    count(array_filter($schemaOperations))
);
$lines[] = '';
$lines[] = '::callout{icon="i-heroicons-arrow-path"}';
$lines[] = 'Generated by `composer docs:generate-coverage`. Every number is computed from the endpoint classes and the schema, so this page cannot drift from the code.';
$lines[] = '::';
$lines[] = '';
$lines[] = '## Covered';
$lines[] = '';
$lines[] = '| Resource | Operations | | Endpoints |';
$lines[] = '| -------- | ---------: | :--- | --------- |';

foreach ($coveredResources as $resource => $data) {

    $percentage = (int) round($data['covered'] / max(1, $data['total']) * 100);

    $endpoints = implode(' ', array_map(
        fn (string $route) => sprintf('[`%s`](%s)', str_replace('/client/', '', $route), $route),
        array_keys($data['endpoints'])
    ));

    $lines[] = sprintf(
        '| %s | %d / %d | %s | %s |',
        $label($resource),
        $data['covered'],
        $data['total'],
        $percentage === 100 ? '**all**' : $percentage . '%',
        $endpoints
    );
}

$lines[] = '';
$lines[] = '## Not covered yet';
$lines[] = '';
$lines[] = sprintf(
    'The remaining %d resources — %d operations — have no endpoint here, largest first. Any of them can still be called with [custom requests](/getting-started/usage#making-customundocumented-requests).',
    count($missingResources),
    array_sum(array_column($missingResources, 'total'))
);
$lines[] = '';

$columns = 3;
$missingLabels = array_map(
    fn (string $resource) => sprintf('%s (%d)', $label($resource), $missingResources[$resource]['total']),
    array_keys($missingResources)
);
$rows = (int) ceil(count($missingLabels) / $columns);
$padded = array_pad($missingLabels, $rows * $columns, '');

$lines[] = '| | | |';
$lines[] = '| --- | --- | --- |';

for ($row = 0; $row < $rows; $row++) {

    $cells = [];

    for ($column = 0; $column < $columns; $column++) {
        $cells[] = $padded[$column * $rows + $row];
    }

    $lines[] = '| ' . implode(' | ', $cells) . ' |';
}

if ($deprecatedInUse !== []) {

    $lines[] = '';
    $lines[] = '## Deprecated operations still implemented';
    $lines[] = '';
    $lines[] = 'Cloudflare marks these deprecated in the schema. They still answer, and this package still exposes them, but reach for the replacement where there is one.';
    $lines[] = '';

    foreach ($deprecatedInUse as $operation => $files) {

        $where = implode(', ', array_map(
            function (string $file) use ($routes): string {
                $route = $routes[classOf($file)];

                return sprintf('[`%s`](%s)', str_replace('/client/', '', $route), $route);
            },
            $files
        ));

        $lines[] = sprintf('- `%s` — %s', $operation, $where);
    }
}

if ($unknown !== []) {

    $lines[] = '';
    $lines[] = '## Not in the published schema';
    $lines[] = '';
    $lines[] = 'This package issues these requests and the schema does not document them, so either Cloudflare has not published them or they have been retired.';
    $lines[] = '';

    foreach (array_keys($unknown) as $operation) {
        $lines[] = sprintf('- `%s`', $operation);
    }
}

$lines[] = '';

file_put_contents($outFile, implode("\n", $lines));

printf(
    "Generated %s: %d/%d operations (%d%%), %d/%d resources.\n",
    realpath($outFile) ?: $outFile,
    $liveCovered,
    $liveTotal,
    (int) round($liveCovered / max(1, $liveTotal) * 100),
    count($coveredResources),
    count($resources)
);

if ($deprecatedInUse !== []) {
    printf("Deprecated operations implemented: %d\n", count($deprecatedInUse));
}

if ($unknown !== []) {
    printf("Operations this package issues that the schema does not document: %d\n", count($unknown));
}
