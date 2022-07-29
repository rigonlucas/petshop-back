<?php

namespace App\Helpers\BitwiseFlags;

use Illuminate\Database\Query\Builder;

/**
 * Helper para operacoes bitwise em query builder
 */
class BitwiseFlagsQueryBuilderHelper
{
    public static function whereFlagActive(Builder $builder, string $column, int $flag, string $boolean = 'and'): Builder
    {
        return $builder->whereRaw("({$column} & ?) != 0", [$flag], $boolean);
    }

    public static function whereFlagNotActive(Builder $builder, string $column, int $flag, string $boolean = 'and'): Builder
    {
        return $builder->whereRaw("({$column} & ?) = 0", [$flag], $boolean);
    }
}
