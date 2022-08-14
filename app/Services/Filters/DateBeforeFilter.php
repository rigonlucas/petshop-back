<?php

namespace App\Services\Filters;

use Illuminate\Database\Eloquent\Builder;

class DateBeforeFilter implements FilterInterface
{
    public function __construct(private readonly string $column)
    {
    }

    public function filter(Builder $builder, $value): void {
        if (!$value) {
            return;
        }

        $builder->whereDate($this->column, '<=', $value);
    }
}