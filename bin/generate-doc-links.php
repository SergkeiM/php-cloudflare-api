<?php

/**
 * Rewrites the `@link` tag on every endpoint method to the page Cloudflare
 * actually serves for that operation.
 *
 * Cloudflare retired the `/api/operations/{slug}` addresses these docblocks were
 * written against. Many now redirect, but a large share 404 outright, and the
 * dead ones are invisible until someone clicks. Rather than curate hundreds of
 * URLs by hand, this reads the address out of bin/cloudflare-api-schema.php,
 * where bin/refresh-cloudflare-schema.php records it alongside each operation.
 *
 * Only links into Cloudflare's API reference are touched. Links into the product
 * documentation — the prose pages about multipart uploads or Time Travel — are
 * left exactly as written, because no schema field knows about them.
 *
 * Usage: php bin/generate-doc-links.php [--dry-run]
 */

$schema = require __DIR__ . '/cloudflare-api-schema.php';

$endpointsDir = __DIR__ . '/../src/Endpoints';
$dryRun = in_array('--dry-run', array_slice($argv, 1), true);

const HTTP_METHODS = 'get|post|put|patch|delete';

/** Any address inside Cloudflare's API reference, old scheme or new. */
const REFERENCE_LINK = '~https://developers\.cloudflare\.com/api/(?:operations|resources)/[^\s*]*~';

if (!isset($schema['docs']) || $schema['docs'] === []) {
    fwrite(STDERR, "The schema snapshot carries no documentation addresses.\n");
    fwrite(STDERR, "Run bin/refresh-cloudflare-schema.php first.\n");
    exit(1);
}

/**
 * The operation a method issues, as `METHOD /normalised/path`.
 *
 * Endpoint methods issue exactly one request, so the first one found in the
 * body is the method's operation. A method that issues none — a child accessor,
 * or one that only delegates — has no operation and no link to write.
 */
function operationIn(string $body): ?string
{
    if (preg_match('/getHttpClient\(\)\s*->\s*(' . HTTP_METHODS . ')\(\s*([\'"])(.+?)\2/s', $body, $match) !== 1) {
        return null;
    }

    $path = $match[3];

    // A scoped endpoint serves both an account and a zone path; the account one
    // is the address Cloudflare documents it at.
    $path = preg_replace('/\{\$this->scopePath\([^}]*\)\}/', '/accounts/{}', $path);
    $path = '/' . ltrim((string) preg_replace('/\{\$[^}]+\}/', '{}', (string) $path), '/');

    return strtoupper($match[1]) . ' ' . $path;
}

$files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($endpointsDir));

$rewritten = 0;
$added = 0;
$unchanged = 0;
$touchedFiles = 0;
$noAddress = [];

foreach ($files as $file) {

    if ($file->getExtension() !== 'php') {
        continue;
    }

    $path = $file->getPathname();
    $source = (string) file_get_contents($path);

    // Each docblock and the signature it introduces, with offsets, so the body
    // can be read off as the slice up to the next one.
    // A docblock cannot contain `*/`, so the block matched here is the method's
    // own. Allowing `.*?` to span instead would let the match start at the class
    // docblock and swallow it, rewriting the class's link with the first
    // method's address.
    preg_match_all(
        '~(/\*\*(?:(?!\*/).)*+\*/)\s*public function\s+\w+\s*\(~s',
        $source,
        $matches,
        PREG_OFFSET_CAPTURE | PREG_SET_ORDER
    );

    if ($matches === []) {
        continue;
    }

    $replacements = [];

    foreach ($matches as $i => $match) {

        [$whole, $wholeOffset] = $match[0];
        [$docblock, $docblockOffset] = $match[1];

        $bodyStart = $wholeOffset + strlen($whole);
        $bodyEnd = isset($matches[$i + 1]) ? $matches[$i + 1][0][1] : strlen($source);
        $body = substr($source, $bodyStart, $bodyEnd - $bodyStart);

        $operation = operationIn($body);

        if ($operation === null) {
            continue;
        }

        $url = $schema['docs'][$operation] ?? null;

        if ($url === null) {
            $noAddress[$operation] = basename($path);
            continue;
        }

        $hasReferenceLink = preg_match(REFERENCE_LINK, $docblock) === 1;

        if ($hasReferenceLink) {

            $updated = preg_replace(REFERENCE_LINK, $url, $docblock);

            if ($updated === $docblock) {
                $unchanged++;
                continue;
            }

            $rewritten++;

        } else {

            // No reference link at all. Add one directly above the first
            // `@param`, where every other docblock in this package keeps it.
            $indent = str_repeat(' ', 5);
            $tag = "*\n{$indent}* @link {$url}\n{$indent}";

            $updated = preg_replace(
                '~\n(\s+)\* @(param|return|throws)~',
                "\n\$1* @link {$url}\n\$1* @\$2",
                $docblock,
                1
            );

            if ($updated === null || $updated === $docblock) {
                continue;
            }

            $added++;
        }

        $replacements[] = [$docblockOffset, strlen($docblock), $updated];
    }

    if ($replacements === []) {
        continue;
    }

    // Applied back to front so earlier offsets stay valid.
    foreach (array_reverse($replacements) as [$offset, $length, $updated]) {
        $source = substr_replace($source, $updated, $offset, $length);
    }

    $touchedFiles++;

    if (!$dryRun) {
        file_put_contents($path, $source);
    }
}

printf(
    "%s %d links rewritten, %d added, %d already correct, across %d files.\n",
    $dryRun ? 'Would write:' : 'Wrote:',
    $rewritten,
    $added,
    $unchanged,
    $touchedFiles
);

if ($noAddress !== []) {
    printf("\n%d operations have no page in Cloudflare's reference; their links were left alone:\n", count($noAddress));

    ksort($noAddress);

    foreach ($noAddress as $operation => $file) {
        printf("  %-62s %s\n", $operation, $file);
    }
}
