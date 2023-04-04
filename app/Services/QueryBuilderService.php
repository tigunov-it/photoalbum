<?php

namespace App\Services;

use Illuminate\Contracts\Database\Eloquent\Builder as BuilderContract;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
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

    public static function addSearchWithPaginate(
        BuilderContract|Builder|QueryBuilder $builder,
        ?string $value,
        string $property,
        ?int $perPage,
        ?int $page,
    ): LengthAwarePaginator {

        if ($value !== null) {
            $builder = self::addSearchQuery($builder, $value, $property);
        }

        return $builder->paginate(perPage: $perPage, page: $page);
    }
}
