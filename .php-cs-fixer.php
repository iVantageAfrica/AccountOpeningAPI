<?php

$finder = PhpCsFixer\Finder::create()
    ->in(__DIR__) // Scan all files in the project directory
    ->exclude('vendor') // Exclude vendor folder
    ->name('*.php'); // Only target PHP files

return (new PhpCsFixer\Config())
    ->setRules([
        '@PSR12' => true,
        'array_syntax' => ['syntax' => 'short'], // [] instead of array()
        'no_unused_imports' => true,             // remove unused use statements
        'single_quote' => true,                  // prefer single quotes
        'ordered_imports' => ['sort_algorithm' => 'alpha'], // alphabetize imports
        'trailing_comma_in_multiline' => true,   // cleaner git diffs
    ])
    ->setFinder($finder);
