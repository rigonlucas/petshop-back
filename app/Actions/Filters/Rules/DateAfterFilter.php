<?php

namespace App\Actions\Filters\Rules;

use App\Actions\Filters\FilterInterface;
use Illuminate\Database\Eloquent\Builder;

class DateAfterFilter implements FilterInterface
{
    public function __construct(private readonly string $column)
    {
    }

    public function filter(Builder $builder, $value): void {
        if (!$value) {
            return;
        }

        $builder->whereDate($this->column, '>=', $value);
    }
}