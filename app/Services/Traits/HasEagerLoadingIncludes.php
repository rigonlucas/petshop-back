<?php

namespace App\Services\Traits;

use Illuminate\Database\Eloquent\Builder;

trait HasEagerLoadingIncludes
{
    private array $requestedIncludes = [];

    abstract function eagerIncludesRelations(): array;

    public function setRequestedIncludes(Array $includes): self
    {
        $this->requestedIncludes = $includes;
        return $this;
    }

    protected function applyIncludesEagerLoading(Builder $query): void
    {
        $includes = array_intersect_key(
            self::eagerIncludesRelations(),
            array_flip($this->requestedIncludes)
        );
        $includesRelations = array_merge(...array_values($includes));

        $query->with($includesRelations);
    }

}