<?php

$finder = (new PhpCsFixer\Finder())
    ->in(__DIR__)
    ->exclude([
        "local-test",
        ".github",
        "vendor"
    ]);

return (new PhpCsFixer\Config())
    ->setRules([
        '@PSR12' => true,
    ])
    ->setFinder($finder);