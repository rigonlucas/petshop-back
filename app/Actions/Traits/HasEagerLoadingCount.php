<?php

namespace App\Actions\Traits;

use Illuminate\Database\Eloquent\Builder;

trait HasEagerLoadingCount
{
    public function applyEagerLoadgingCount(Builder $builder, ?string $includes, ?array $relationsAvailables = null): void
    {
        if (!is_null($includes)) {
            $includes = explode(',', $includes);
            $includes = match (!is_null($relationsAvailables)) {
                true => array_intersect($includes, $relationsAvailables),
                default => null,
            };
            if ($includes) {
                $builder->withCount($includes);
            }
        }
    }
}