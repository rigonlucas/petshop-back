<?php

namespace App\Services\Ordinations;

use Illuminate\Database\Eloquent\Builder;

interface OrdinationInterface
{
    public function orderBy(Builder $builder, string $value): void;
    public function getDirection(): string;
}