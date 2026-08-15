<?php

/**
 * Scaffolds Markdown reference pages under docs/content/2.client from the
 * Cloudflare\Endpoints classes, using PHP Reflection + phpdocumentor/reflection-docblock
 * to pull method signatures and docblock text straight from the source.
 *
 * These pages are a mechanical reference (one section per public method), meant to be
 * regenerated whenever endpoints change. They are separate from the hand-curated
 * docs/content/2.api tree, which groups things by Cloudflare product/concept and
 * carries prose, cross-links, and worked examples that reflection can't produce.
 *
 * Usage: php bin/generate-client-docs.php
 */

require __DIR__ . '/../vendor/autoload.php';

use phpDocumentor\Reflection\DocBlockFactory;
use phpDocumentor\Reflection\DocBlock;

$docFactory = DocBlockFactory::createInstance();

$outDir = __DIR__ . '/../docs/content/2.client';
$clientFile = __DIR__ . '/../src/Client.php';

// ---------------------------------------------------------------------
// Helpers
// ---------------------------------------------------------------------

function kebab(string $s): string
{
    $s = preg_replace('/(?<=[a-z0-9])(?=[A-Z])/', '-', $s);
    $s = preg_replace('/(?<=[A-Z])(?=[A-Z][a-z])/', '-', $s);
    return strtolower($s);
}

function snakeUpper(string $s): string
{
    $s = preg_replace('/(?<=[a-z0-9])(?=[A-Z])/', '_', $s);
    $s = preg_replace('/(?<=[A-Z])(?=[A-Z][a-z])/', '_', $s);
    return strtoupper($s);
}

const ACRONYMS = [
    'ca' => 'CA', 'dns' => 'DNS', 'dnssec' => 'DNSSEC', 'ip' => 'IP', 'ips' => 'IPs',
    'kv' => 'KV', 'd1' => 'D1', 'r2' => 'R2', 'ssl' => 'SSL', 'id' => 'ID', 'ids' => 'IDs',
    'url' => 'URL', 'waf' => 'WAF', 'ua' => 'UA', 'acm' => 'ACM',
];

function humanize(string $kebabOrCamel): string
{
    $parts = preg_split('/[-\s]+/', kebab($kebabOrCamel));
    $words = array_map(function ($w) {
        return ACRONYMS[strtolower($w)] ?? ucfirst($w);
    }, $parts);
    return implode(' ', $words);
}

function methodTitle(string $methodName): string
{
    return humanize($methodName);
}

function paramPlaceholder(ReflectionParameter $p): string
{
    $type = $p->getType();
    $name = $p->getName();

    if ($type instanceof ReflectionNamedType && !$type->isBuiltin()) {
        return '$' . $name;
    }

    if (!$type instanceof ReflectionNamedType) {
        return '$' . $name; // union/intersection types - leave as a variable placeholder
    }

    return match ($type->getName()) {
        'string' => "'" . snakeUpper($name) . "'",
        'bool' => 'true',
        'int', 'float' => '1',
        'array' => '[]',
        default => '$' . $name,
    };
}

function phpLiteral(mixed $value): string
{
    if (is_array($value)) {
        return empty($value) ? '[]' : var_export($value, true);
    }
    if (is_bool($value)) {
        return $value ? 'true' : 'false';
    }
    if (is_string($value)) {
        return "'{$value}'";
    }
    return var_export($value, true);
}

function yamlString(string $s): string
{
    // A docblock description may run to several lines, and a continuation
    // starting at column 0 — a `-` bullet, say — ends the quoted scalar and
    // reopens as a sequence, quietly corrupting the whole params block. Keep
    // every value on one line.
    $s = (string) preg_replace('/\s*\R\s*/', ' ', $s);
    $s = str_replace(['\\', '"'], ['\\\\', '\\"'], $s);

    return '"' . trim($s) . '"';
}

function docblockFor(DocBlockFactory $factory, Reflector $reflector): ?DocBlock
{
    try {
        return $factory->create($reflector);
    } catch (\Throwable) {
        return null;
    }
}

// ---------------------------------------------------------------------
// 1. Parse the top-level accessor map straight out of Client::api()
// ---------------------------------------------------------------------

$clientSrc = file_get_contents($clientFile);
preg_match_all(
    "/'(\w+)'\s*=>\s*new Endpoints\\\\([\w\\\\]+)\(/",
    $clientSrc,
    $matches,
    PREG_SET_ORDER
);

$topLevel = [];
foreach ($matches as $m) {
    $topLevel[$m[1]] = 'Cloudflare\\Endpoints\\' . $m[2];
}

if (empty($topLevel)) {
    fwrite(STDERR, "Could not parse any endpoints out of {$clientFile}\n");
    exit(1);
}

// ---------------------------------------------------------------------
// 2. Reflect each class: split public, self-declared methods into
//    "API methods" (return a response) vs "child accessors" (return
//    another Endpoint instance).
// ---------------------------------------------------------------------

function analyzeClass(string $class): array
{
    $rc = new ReflectionClass($class);
    $apiMethods = [];
    $children = []; // accessorMethodName => childClass

    foreach ($rc->getMethods(ReflectionMethod::IS_PUBLIC) as $m) {
        if ($m->getDeclaringClass()->getName() !== $rc->getName()) {
            continue;
        }
        if ($m->isConstructor() || $m->isStatic()) {
            continue;
        }

        $rt = $m->getReturnType();
        if ($rt instanceof ReflectionNamedType && !$rt->isBuiltin() && is_subclass_of($rt->getName(), \Cloudflare\Endpoints\AbstractEndpoint::class)) {
            $children[$m->getName()] = $rt->getName();
            continue;
        }

        $apiMethods[] = $m;
    }

    return [$rc, $apiMethods, $children];
}

// ---------------------------------------------------------------------
// 3. Markdown rendering
// ---------------------------------------------------------------------

function renderMethodSection(DocBlockFactory $factory, ReflectionMethod $m, string $accessorChain): string
{
    $docblock = docblockFor($factory, $m);

    $summary = $docblock?->getSummary() ?? '';
    $description = $docblock ? trim((string) $docblock->getDescription()) : '';

    $paramDescriptions = [];
    if ($docblock) {
        foreach ($docblock->getTagsByName('param') as $tag) {
            if (!$tag instanceof \phpDocumentor\Reflection\DocBlock\Tags\Param) {
                continue;
            }
            if ($tag->getVariableName()) {
                $paramDescriptions[$tag->getVariableName()] = trim((string) $tag->getDescription());
            }
        }
    }

    $link = '';
    if ($docblock) {
        foreach ($docblock->getTagsByName('link') as $tag) {
            if (!$tag instanceof \phpDocumentor\Reflection\DocBlock\Tags\Link) {
                continue;
            }
            $link = trim((string) $tag);
            break;
        }
    }

    $args = array_map('paramPlaceholder', $m->getParameters());
    $call = "\$response = \$client->{$accessorChain}->{$m->getName()}(" . implode(', ', $args) . ');';

    $out = "## " . methodTitle($m->getName()) . "\n\n";

    if ($summary !== '') {
        $out .= $summary . "\n\n";
    }
    if ($description !== '') {
        $out .= $description . "\n\n";
    }

    if (!empty($m->getParameters())) {
        $out .= "::params-table\n---\nparams:\n";
        foreach ($m->getParameters() as $p) {
            $type = $p->getType() instanceof ReflectionNamedType ? $p->getType()->getName() : 'mixed';
            if ($p->getType() instanceof ReflectionNamedType && $p->getType()->allowsNull()) {
                $type .= '|null';
            }

            $out .= "  - name: " . yamlString($p->getName()) . "\n";
            $out .= "    type: " . yamlString($type) . "\n";
            $out .= "    required: " . ($p->isOptional() ? 'false' : 'true') . "\n";

            $desc = $paramDescriptions[$p->getName()] ?? '';
            if ($desc !== '') {
                $out .= "    description: " . yamlString($desc) . "\n";
            }

            if ($p->isDefaultValueAvailable()) {
                $default = $p->getDefaultValue();
                if ($default !== null) {
                    $out .= "    default: " . yamlString(phpLiteral($default)) . "\n";
                }
            }
        }
        $out .= "---\n::\n\n";
    }

    $out .= "```php [php]\n{$call}\n```\n\n";

    if ($link !== '') {
        $out .= "::callout{icon=\"i-simple-icons-cloudflare\" to=\"{$link}\"}\n";
        $out .= "View this operation on the Cloudflare API Reference\n";
        $out .= "::\n\n";
    }

    return $out;
}

function frontmatter(string $title, string $description): string
{
    $description = str_replace(["\n", '"'], [' ', "'"], $description);
    return <<<MD
---
title: {$title}
description: "{$description}"
navigation:
    title: {$title}
---


MD;
}

// ---------------------------------------------------------------------
// 4. Walk the tree and write files
//
// Recursive to any depth: a node with no child accessors renders as a
// flat NN.slug.md file; a node with children renders as a folder with
// its own 00.index.md (API methods + a Related list) plus one file
// (flat or, recursively, another folder) per child.
// ---------------------------------------------------------------------

function writeNode(
    DocBlockFactory $docFactory,
    string $accessorName,
    string $accessorChain,
    string $class,
    string $dir,
    int $prefixIndex,
    string $urlPath
): void {
    [$rc, $apiMethods, $children] = analyzeClass($class);

    $slug = kebab($accessorName);
    $prefix = str_pad((string) $prefixIndex, 2, '0', STR_PAD_LEFT);
    $title = humanize($accessorName);

    $classDoc = docblockFor($docFactory, $rc);
    $realSummary = $classDoc?->getSummary() ?: '';
    $classSummary = $realSummary !== '' ? $realSummary : "{$title} endpoint reference.";

    if (empty($children)) {
        // flat file: .../NN.slug.md
        $body = frontmatter($title, $classSummary);
        if ($realSummary !== '') {
            $body .= $realSummary . "\n\n";
        }
        foreach ($apiMethods as $m) {
            $body .= renderMethodSection($docFactory, $m, $accessorChain);
        }
        file_put_contents("{$dir}/{$prefix}.{$slug}.md", $body);
        return;
    }

    // folder with index.md + one file (or subfolder) per child
    $nodeDir = "{$dir}/{$prefix}.{$slug}";
    @mkdir($nodeDir, 0777, true);

    $body = frontmatter($title, $classSummary);
    if ($realSummary !== '') {
        $body .= $realSummary . "\n\n";
    }

    foreach ($apiMethods as $m) {
        $body .= renderMethodSection($docFactory, $m, $accessorChain);
    }

    $body .= "## Related\n\n";
    foreach ($children as $childAccessor => $childClass) {
        $childTitle = humanize($childAccessor);
        $body .= "- [{$childTitle}]({$urlPath}/" . kebab($childAccessor) . ")\n";
    }
    $body .= "\n";

    file_put_contents("{$nodeDir}/00.index.md", $body);

    $childIndex = 1;
    foreach ($children as $childAccessor => $childClass) {
        writeNode(
            $docFactory,
            $childAccessor,
            "{$accessorChain}->{$childAccessor}()",
            $childClass,
            $nodeDir,
            $childIndex++,
            "{$urlPath}/" . kebab($childAccessor)
        );
    }
}

function rrmdir(string $dir): void
{
    if (!is_dir($dir)) {
        return;
    }
    foreach (scandir($dir) as $entry) {
        if ($entry === '.' || $entry === '..') {
            continue;
        }
        $path = "{$dir}/{$entry}";
        is_dir($path) ? rrmdir($path) : unlink($path);
    }
    rmdir($dir);
}

// Wipe the generated tree first so renumbered/removed accessors don't
// leave stale files behind (this whole directory is mechanical output;
// hand-curated docs live under 2.api instead).
rrmdir($outDir);
@mkdir($outDir, 0777, true);
file_put_contents($outDir . '/.navigation.yml', "title: Client Reference\nicon: i-lucide-terminal\n");

$topIndex = 0;

foreach ($topLevel as $accessorName => $class) {
    writeNode(
        $docFactory,
        $accessorName,
        "{$accessorName}()",
        $class,
        $outDir,
        $topIndex++,
        '/client/' . kebab($accessorName)
    );
}

echo "Generated client reference docs in {$outDir}\n";
