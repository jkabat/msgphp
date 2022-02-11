<?php

declare(strict_types=1);

use PhpCsFixer\Config;
use PhpCsFixer\Finder;

$rules = [
    '@PhpCsFixer' => true,
    '@PhpCsFixer:risky' => true,
    '@PHP71Migration' => true,
    '@PHP71Migration:risky' => true,
    '@PHPUnit75Migration:risky' => true,
    'header_comment' => ['header' => ''],
    'list_syntax' => ['syntax' => 'short'],
    'nullable_type_declaration_for_default_null_value' => true,
    'php_unit_strict' => false,
    'php_unit_test_case_static_method_calls' => ['call_type' => 'self'],
    'php_unit_test_class_requires_covers' => false,
    'phpdoc_line_span' => ['const' => 'single', 'method' => 'multi', 'property' => 'single'],
    'phpdoc_to_comment' => false,
    'self_static_accessor' => true,
];

return (new Config())
    ->setUsingCache(true)
    ->setCacheFile(__DIR__.'/build/php-cs-fixer.cache')
    ->setRules($rules)
    ->setRiskyAllowed(true)
    ->setFinder(
        Finder::create()
            ->in([
                __DIR__.'/src',
                __DIR__.'/tests',
            ])
            ->append([
                __FILE__,
            ])
            ->notPath('EavBundle/Resources/')
            ->notPath('EavBundle/DependencyInjection/Configuration.php')
            ->notPath('UserBundle/Resources/')
            ->notPath('UserBundle/DependencyInjection/Configuration.php')
    )
;
