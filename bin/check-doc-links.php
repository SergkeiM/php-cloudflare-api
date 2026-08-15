<?php

/**
 * Checks that every `@link` in the endpoint classes still resolves.
 *
 * Cloudflare moves its documentation, and a docblock link that 404s is worse
 * than no link at all: it reads as a promise the package does not keep, and
 * nothing in a test suite notices. Run this in CI so a dead link fails the
 * build rather than waiting for someone to click it.
 *
 * With --prune, links that answer 404 are removed from the source. That is for
 * the operations Cloudflare documents nowhere — the method keeps its prose, and
 * simply stops pointing at a page that is not there.
 *
 * Usage: php bin/check-doc-links.php [--prune] [--quiet]
 */

$endpointsDir = __DIR__ . '/../src/Endpoints';

$arguments = array_slice($argv, 1);
$prune = in_array('--prune', $arguments, true);
$quiet = in_array('--quiet', $arguments, true);

const CONCURRENCY = 10;

/**
 * Every documentation link in the package, mapped to the files carrying it.
 *
 * @return array<string, array<string, true>> url => [file => true]
 */
function documentationLinks(string $directory): array
{
    $links = [];

    $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($directory));

    foreach ($files as $file) {

        if ($file->getExtension() !== 'php') {
            continue;
        }

        preg_match_all(
            '~@link\s+(https://developers\.cloudflare\.com/\S+?)\s*$~m',
            (string) file_get_contents($file->getPathname()),
            $matches
        );

        foreach ($matches[1] as $url) {
            $links[$url][$file->getPathname()] = true;
        }
    }

    ksort($links);

    return $links;
}

/**
 * Fetch every URL, following redirects, and report the status each settles on.
 *
 * @param array<int, string> $urls
 *
 * @return array<string, int> url => status
 */
function statuses(array $urls, bool $quiet): array
{
    $results = [];
    $done = 0;
    $total = count($urls);

    foreach (array_chunk($urls, CONCURRENCY) as $batch) {

        $multi = curl_multi_init();
        $handles = [];

        foreach ($batch as $url) {
            $handle = curl_init($url);
            curl_setopt_array($handle, [
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_NOBODY => true,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_USERAGENT => 'php-cloudflare-api docs link check',
            ]);
            curl_multi_add_handle($multi, $handle);
            $handles[$url] = $handle;
        }

        do {
            curl_multi_exec($multi, $running);
            curl_multi_select($multi);
        } while ($running > 0);

        foreach ($handles as $url => $handle) {
            $results[$url] = (int) curl_getinfo($handle, CURLINFO_RESPONSE_CODE);
            curl_multi_remove_handle($multi, $handle);
        }

        curl_multi_close($multi);

        $done += count($batch);

        if (!$quiet) {
            fwrite(STDERR, sprintf("\rchecked %d/%d", $done, $total));
        }
    }

    if (!$quiet) {
        fwrite(STDERR, "\r" . str_repeat(' ', 24) . "\r");
    }

    return $results;
}

$links = documentationLinks($endpointsDir);

if ($links === []) {
    fwrite(STDERR, "No documentation links found in {$endpointsDir}\n");
    exit(1);
}

$results = statuses(array_keys($links), $quiet);

// Anything that did not answer cleanly gets a second attempt on its own, so a
// rate limit or a dropped connection is not reported as a dead page.
$suspect = array_keys(array_filter($results, static fn (int $status): bool => $status < 200 || $status >= 400));

if ($suspect !== []) {
    if (!$quiet) {
        fwrite(STDERR, sprintf("retrying %d\n", count($suspect)));
    }

    sleep(2);

    $results = array_merge($results, statuses($suspect, $quiet));
}

$dead = array_filter($results, static fn (int $status): bool => $status < 200 || $status >= 400);

printf("%d links checked, %d dead.\n", count($links), count($dead));

if ($dead === []) {
    exit(0);
}

echo "\n";

foreach (array_keys($dead) as $url) {
    printf("  %d  %s\n", $results[$url], $url);
    foreach (array_keys($links[$url]) as $file) {
        printf("        %s\n", str_replace(dirname(__DIR__) . '/', '', $file));
    }
}

if (!$prune) {
    echo "\nRe-run with --prune to strip these, or fix them at the source that writes them.\n";
    exit(1);
}

$pruned = 0;
$touched = [];

foreach (array_keys($dead) as $url) {
    foreach (array_keys($links[$url]) as $file) {

        $source = (string) file_get_contents($file);

        // Take the whole tag line, and the blank docblock line left behind when
        // the link was the only thing between the summary and the parameters.
        $updated = preg_replace(
            '~[ \t]*\*[ \t]*@link[ \t]+' . preg_quote($url, '~') . '[ \t]*\R(?:[ \t]*\*[ \t]*\R)?~',
            '',
            $source,
            -1,
            $count
        );

        if ($updated === null || $count === 0) {
            continue;
        }

        // A link that ended a docblock leaves the blank line above it dangling.
        $updated = preg_replace('~(?:[ \t]*\*[ \t]*\R)+([ \t]*\*/)~', '$1', $updated);

        file_put_contents($file, $updated);
        $pruned += $count;
        $touched[$file] = true;
    }
}

printf("\nPruned %d dead links from %d files.\n", $pruned, count($touched));
