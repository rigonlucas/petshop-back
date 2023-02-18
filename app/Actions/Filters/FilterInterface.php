<?php

namespace App\Actions\Filters;

use Illuminate\Database\Eloquent\Builder;

interface FilterInterface
{
    public function filter(Builder $builder, $value): void;
}