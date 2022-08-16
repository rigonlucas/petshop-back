<?php

namespace App\Services\Relations;

use Illuminate\Database\Eloquent\Builder;

class ApplyEagerLoading
{
    public static function apply(Builder $builder, ?string $includes, ?array $relationsAvailables = null): void
    {
        if (!is_null($includes)) {
            $includes = explode(',', $includes);
            $includes = match (!is_null($relationsAvailables)) {
                true => array_intersect($includes, $relationsAvailables),
                default => null,
            };
            if ($includes) {
                $builder->with($includes);
            }
        }
    }
}