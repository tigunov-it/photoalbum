<?php

declare(strict_types=1);

use Rector\CodeQuality\Rector\Class_\InlineConstructorDefaultToPropertyRector;
use Rector\Config\RectorConfig;
use Rector\Set\ValueObject\LevelSetList;
use Rector\Set\ValueObject\SetList;
use RectorLaravel\Set\LaravelSetList;

return static function (RectorConfig $rectorConfig): void {
    // $rectorConfig->paths([
    //     __DIR__ . '/app',
    //     __DIR__ . '/bootstrap',
    //     __DIR__ . '/config',
    //     __DIR__ . '/lang',
    //     __DIR__ . '/public',
    //     __DIR__ . '/resources',
    //     __DIR__ . '/routes',
    //     __DIR__ . '/tests',
    // ]);

    // register a single rule
    $rectorConfig->rule(InlineConstructorDefaultToPropertyRector::class);

    // define sets of rules
    $rectorConfig->sets([
        SetList::ACTION_INJECTION_TO_CONSTRUCTOR_INJECTION,
        SetList::CODE_QUALITY,
        SetList::CODING_STYLE,
        SetList::DEAD_CODE,
        SetList::GMAGICK_TO_IMAGICK,
        SetList::MYSQL_TO_MYSQLI,
        // SetList::NAMING,
        SetList::PHP_82,
        SetList::PRIVATIZATION,
        SetList::PSR_4,
        SetList::TYPE_DECLARATION,
        SetList::EARLY_RETURN,
        LevelSetList::UP_TO_PHP_82,
        LaravelSetList::ARRAY_STR_FUNCTIONS_TO_STATIC_CALL,
        LaravelSetList::LARAVEL_100,
        // LaravelSetList::LARAVEL_STATIC_TO_INJECTION,
        LaravelSetList::LARAVEL_CODE_QUALITY,
        LaravelSetList::LARAVEL_ARRAY_STR_FUNCTION_TO_STATIC_CALL,
        LaravelSetList::LARAVEL_LEGACY_FACTORIES_TO_CLASSES,
    ]);
};
