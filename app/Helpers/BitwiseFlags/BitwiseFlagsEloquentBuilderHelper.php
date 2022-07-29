<?php

namespace App\Helpers\BitwiseFlags;

use Illuminate\Database\Eloquent\Builder;

/**
 * Helper para operacoes bitwise em eloquent builder
 */
class BitwiseFlagsEloquentBuilderHelper
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
