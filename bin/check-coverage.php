<?php

/**
 * Fails when line coverage in a Clover report falls below a threshold.
 *
 * Keeps the coverage gate in this repository rather than in a third-party
 * service, so it enforces the same number locally and in CI, with or without
 * a Codecov account attached.
 *
 * Usage: php bin/check-coverage.php [clover.xml] [minimum-percentage]
 *
 * The minimum also reads from the MIN_COVERAGE environment variable, and
 * defaults to 100, which is where this package sits today.
 */

$report = $argv[1] ?? __DIR__ . '/../clover.xml';
$minimum = (float) ($argv[2] ?? getenv('MIN_COVERAGE') ?: 100);

if (!is_file($report)) {
    fwrite(STDERR, "Coverage report not found: {$report}\n");
    fwrite(STDERR, "Generate one with: vendor/bin/phpunit --coverage-clover=clover.xml\n");
    exit(1);
}

$xml = simplexml_load_file($report);

if ($xml === false || !isset($xml->project->metrics)) {
    fwrite(STDERR, "Could not read Clover metrics out of {$report}\n");
    exit(1);
}

$metrics = $xml->project->metrics;
$covered = (int) $metrics['coveredstatements'];
$total = (int) $metrics['statements'];

if ($total === 0) {
    fwrite(STDERR, "The report covers no statements at all, which is never right.\n");
    exit(1);
}

$percentage = round($covered / $total * 100, 2);
$passed = $percentage >= $minimum;

$summary = sprintf(
    'Line coverage: %.2f%% (%d/%d statements), minimum %.2f%%',
    $percentage,
    $covered,
    $total,
    $minimum
);

echo $summary, "\n";

// Surface the number on the workflow run itself, not just in the log.
$stepSummary = getenv('GITHUB_STEP_SUMMARY');

if (is_string($stepSummary) && $stepSummary !== '') {
    file_put_contents(
        $stepSummary,
        sprintf("### Coverage\n\n%s **%s**\n", $passed ? '✅' : '❌', $summary),
        FILE_APPEND
    );
}

if (!$passed) {
    fwrite(STDERR, sprintf("Coverage dropped below the %.2f%% minimum.\n", $minimum));
    exit(1);
}

// The README badge is a plain shield, so nothing but this check keeps it
// honest. Comparison uses the badge's own precision: a badge reading `100%`
// is satisfied by 100.00%, one reading `99.5%` has to match to the decimal.
$readmePath = __DIR__ . '/../README.md';
$readme = is_file($readmePath) ? (string) file_get_contents($readmePath) : '';

if (preg_match('/Coverage-(\d+(?:\.\d+)?)%25/', $readme, $badge) === 1) {

    $decimals = strlen(substr(strrchr($badge[1], '.') ?: '', 1));
    $rounded = number_format($percentage, $decimals, '.', '');

    if ($badge[1] !== $rounded) {
        fwrite(STDERR, sprintf(
            "The README coverage badge reads %s%%, but coverage is %s%%.\nUpdate the badge in README.md to match.\n",
            $badge[1],
            $rounded
        ));
        exit(1);
    }

    echo "README coverage badge is up to date.\n";
}

exit(0);
