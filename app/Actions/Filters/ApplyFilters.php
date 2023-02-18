<?php

namespace App\Actions\Filters;

use Closure;
use Illuminate\Database\Eloquent\Builder;
use InvalidArgumentException;

class ApplyFilters
{
    public static function apply(Builder $builder, array $filters, array $data): void
    {
        foreach ($filters as $filterName => $filter) {
            if ($filter instanceof Closure) {
                $filter($builder, $data[$filterName]);
                continue;
            }

            if (!($filter instanceof FilterInterface)) {
                throw new InvalidArgumentException('Filtro não implementa interface');
            }

            $filter->filter($builder, $data[$filterName]);
        }
    }
}