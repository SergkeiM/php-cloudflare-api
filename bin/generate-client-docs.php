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
    $s = str_replace(['\\', '"'], ['\\\\', '\\"'], $s);
    return '"' . $s . '"';
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
// ---------------------------------------------------------------------

@mkdir($outDir, 0777, true);
file_put_contents($outDir . '/.navigation.yml', "title: Client Reference\nicon: i-lucide-terminal\n");

$topIndex = 0;
foreach ($topLevel as $accessorName => $class) {
    [$rc, $apiMethods, $children] = analyzeClass($class);

    $slug = kebab($accessorName);
    $prefix = str_pad((string) $topIndex++, 2, '0', STR_PAD_LEFT);
    $title = humanize($accessorName);

    $classDoc = docblockFor($docFactory, $rc);
    $realSummary = $classDoc?->getSummary() ?: '';
    $classSummary = $realSummary !== '' ? $realSummary : "{$title} endpoint reference.";

    if (empty($children)) {
        // flat file: docs/content/2.client/NN.slug.md
        $body = frontmatter($title, $classSummary);
        if ($realSummary !== '') {
            $body .= $realSummary . "\n\n";
        }
        foreach ($apiMethods as $m) {
            $body .= renderMethodSection($docFactory, $m, "{$accessorName}()");
        }
        file_put_contents("{$outDir}/{$prefix}.{$slug}.md", $body);
        continue;
    }

    // folder with index.md + one file per child
    $dir = "{$outDir}/{$prefix}.{$slug}";
    @mkdir($dir, 0777, true);

    $body = frontmatter($title, $classSummary);
    if ($realSummary !== '') {
        $body .= $realSummary . "\n\n";
    }

    foreach ($apiMethods as $m) {
        $body .= renderMethodSection($docFactory, $m, "{$accessorName}()");
    }

    if (!empty($children)) {
        $body .= "## Related\n\n";
        foreach ($children as $childAccessor => $childClass) {
            $childTitle = humanize($childAccessor);
            $body .= "- [{$childTitle}](/client/{$slug}/" . kebab($childAccessor) . ")\n";
        }
        $body .= "\n";
    }

    file_put_contents("{$dir}/00.index.md", $body);

    $childIndex = 1;
    foreach ($children as $childAccessor => $childClass) {
        [$childRc, $childApiMethods, $grandchildren] = analyzeClass($childClass);

        $childSlug = kebab($childAccessor);
        $childPrefix = str_pad((string) $childIndex++, 2, '0', STR_PAD_LEFT);
        $childTitle = humanize($childAccessor);

        $childClassDoc = docblockFor($docFactory, $childRc);
        $realChildSummary = $childClassDoc?->getSummary() ?: '';
        $childSummary = $realChildSummary !== '' ? $realChildSummary : "{$childTitle} endpoint reference.";

        $childBody = frontmatter($childTitle, $childSummary);
        if ($realChildSummary !== '') {
            $childBody .= $realChildSummary . "\n\n";
        }

        foreach ($childApiMethods as $m) {
            $childBody .= renderMethodSection($docFactory, $m, "{$accessorName}()->{$childAccessor}()");
        }

        if (!empty($grandchildren)) {
            fwrite(STDERR, "WARNING: {$childClass} has its own child accessors — grandchild nesting isn't handled, methods skipped: " . implode(', ', array_keys($grandchildren)) . "\n");
        }

        file_put_contents("{$dir}/{$childPrefix}.{$childSlug}.md", $childBody);
    }
}

echo "Generated client reference docs in {$outDir}\n";
