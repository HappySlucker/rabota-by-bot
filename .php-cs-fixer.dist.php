<?php

declare(strict_types=1);

require_once __DIR__ . '/vendor/autoload.php';

use PhpCsFixer\Finder;
use PhpCsFixer\Config;
use PhpCsFixerCustomFixers\Fixer\MultilinePromotedPropertiesFixer;
use PhpCsFixerCustomFixers\Fixer\NoDoctrineMigrationsGeneratedCommentFixer;
use PhpCsFixerCustomFixers\Fixer\NoDuplicatedArrayKeyFixer;
use PhpCsFixerCustomFixers\Fixer\PhpdocSingleLineVarFixer;
use PhpCsFixerCustomFixers\Fixer\PromotedConstructorPropertyFixer;
use PhpCsFixerCustomFixers\Fixers as CustomFixers;

$finder = Finder::create()->in(['app']);

return (new Config())
    ->registerCustomFixers(new CustomFixers())
    ->setRules([
        '@Symfony' => true,
        'concat_space' => ['spacing' => 'one'],
        'phpdoc_summary' => false,
        'phpdoc_align' => false,
        'phpdoc_separation' => [
            'groups' => [
                ['deprecated', 'link', 'see', 'since'],
                ['author', 'copyright', 'license'],
                ['category', 'package', 'subpackage'],
                ['property', 'property-read', 'property-write'],
                ['ORM*'],
                ['Assert*'],
            ]
        ],
        'no_useless_else' => true,
        'is_null' => true,
        'multiline_whitespace_before_semicolons' => true,
        'list_syntax' => ['syntax' => 'short'],
        'array_syntax' => ['syntax' => 'short'],
        'strict_comparison' => true,
        'strict_param' => true,
        'declare_strict_types' => true,
        'no_unused_imports' => true,
        'ordered_imports' => ['sort_algorithm' => 'alpha'],
        'no_trailing_comma_in_singleline' => true,
        'trailing_comma_in_multiline' => ['elements' => ['arguments', 'arrays', 'match', 'parameters']],
        'method_argument_space' => true,
        'fully_qualified_strict_types' => true,
        'no_unreachable_default_argument_value' => true,
        'static_lambda' => true,
        'no_superfluous_phpdoc_tags' => [
            'remove_inheritdoc' => true,
            'allow_unused_params' => false,
        ],
        'single_line_throw' => false,
        'blank_line_before_statement' => [
            'statements' => [
                'break',
                'continue',
                'declare',
                'do',
                'for',
                'foreach',
                'if',
                'include',
                'include_once',
                'require',
                'require_once',
                'return',
                'switch',
                'throw',
                'try',
                'while',
                'yield',
            ],
        ],
        'compact_nullable_type_declaration' => true,
        'logical_operators' => true,
        'native_constant_invocation' => false,
        'no_alternative_syntax' => true,
        'no_unset_cast' => true,
        'no_useless_return' => true,
        'nullable_type_declaration_for_default_null_value' => true,
        'php_unit_dedicate_assert' => true,
        'php_unit_method_casing' => [
            'case' => 'snake_case',
        ],
        'php_unit_set_up_tear_down_visibility' => true,
        'php_unit_strict' => true,
        'php_unit_test_annotation' => [
            'style' => 'prefix',
        ],
        'phpdoc_no_empty_return' => true,
        'phpdoc_to_comment' => false,
        'phpdoc_order' => true,
        'yoda_style' => false,
        'class_definition' => [
            'inline_constructor_arguments' => false, 'space_before_parenthesis' => true,
        ],
        'types_spaces' => false,
        'blank_line_between_import_groups' => false,
        PromotedConstructorPropertyFixer::name() => true,
        MultilinePromotedPropertiesFixer::name() => true,
        NoDoctrineMigrationsGeneratedCommentFixer::name() => true,
        NoDuplicatedArrayKeyFixer::name() => true,
        PhpdocSingleLineVarFixer::name() => true,
    ])
    ->setFinder($finder);
