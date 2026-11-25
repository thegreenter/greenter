<?php

// PHP CS Fixer v3: vendor/bin/php-cs-fixer fix --dry-run --diff
$finder = PhpCsFixer\Finder::create()
    ->in(__DIR__.'/packages')
    ->in(__DIR__.'/tools')
    ->exclude('Templates')
    ->name('*.php');

return (new PhpCsFixer\Config())
    ->setRules([
        '@Symfony' => true,
        '@PSR12' => true,
        'yoda_style' => false,
    ])
    ->setFinder($finder);
