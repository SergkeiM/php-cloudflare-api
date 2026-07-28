<?php

$finder = (new PhpCsFixer\Finder())
    ->in(__DIR__)
    ->exclude([
        "local-test",
        "docker",
        ".github",
        ".vscode",
        ".phpunit.cache",
        "docs",
        "vendor",
        "node_modules"
    ]);

return (new PhpCsFixer\Config())
    ->setRules([
        '@PSR12' => true,
    ])
    ->setFinder($finder);