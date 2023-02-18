<?php

namespace App\Actions\Ordinations;

use Illuminate\Database\Eloquent\Builder;

class OrderBy implements OrdinationInterface
{
    public function __construct(private readonly string $direction = 'asc')
    {
    }

    public function orderBy(Builder $builder, string $value): void
    {
        $builder->orderBy($value, $this->direction);
    }

    /**
     * @return string
     */
    public function getDirection(): string
    {
        return $this->direction;
    }
}