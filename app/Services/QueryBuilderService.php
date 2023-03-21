<?php

namespace App\Services;

use Illuminate\Contracts\Database\Eloquent\Builder as BuilderContract;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\Builder as QueryBuilder;

final class QueryBuilderService
{
    public static function addSearchQuery(
        BuilderContract|Builder|QueryBuilder $builder,
        string $value,
        string $property,
    ): BuilderContract|Builder|QueryBuilder {
        $value = mb_strtolower($value, 'UTF8');

        return $builder->whereRaw("LOWER({$property}) LIKE ?", ["%{$value}%"]);
    }
}
