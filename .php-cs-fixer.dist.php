<?php

$finder = PhpCsFixer\Finder::create()
    ->in(__DIR__.'/src')
    ->in(__DIR__.'/tests')
    ->append([__FILE__])
    ->notPath('#/Fixtures/#')
    ->exclude([])
;

return (new PhpCsFixer\Config())
    ->setParallelConfig(new PhpCsFixer\Runner\Parallel\ParallelConfig(4, 20))
    ->setUsingCache(false)
    ->setRiskyAllowed(true)
    ->setRules([
        '@PHP84Migration'        => true,
        '@PSR1'                  => true,
        '@PSR2'                  => true,
        '@Symfony'               => true,
        '@Symfony:risky'         => true,
        'array_syntax'           => ['syntax' => 'short'],
        'fopen_flags'            => false,
        'protected_to_private'   => false,
        'combine_nested_dirname' => true,
        'error_suppression'      => false,
        'binary_operator_spaces' => [
            'default' => 'align_single_space_minimal',
        ],
        'declare_equal_normalize' => [
            'space' => 'single',
        ],
        'native_function_invocation' => [
            'include' => ['@compiler_optimized'],
            'scope'   => 'namespaced',
        ],
        'no_superfluous_phpdoc_tags' => false,
        'array_push'                 => true,
        'phpdoc_to_comment'          => false,
    ])
    ->setFinder($finder)
;
