<?php

namespace App\Services\Traits;

use Illuminate\Database\Eloquent\Builder;

trait HasEagerLoading
{
    public function applyEagerLoadging(Builder $builder, ?string $includes, ?array $relationsAvailables = null): void
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