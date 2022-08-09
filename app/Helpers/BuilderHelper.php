<?php

namespace App\Helpers;

use Illuminate\Database\Eloquent\Builder;

final class BuilderHelper
{
    /**
     * @param int|float|string|\DateTime $firstValue
     * @param int|float|string|\DateTime $secondValue
     */
    public static function overlap(Builder $baseBuilder, string $firstColumn, string $secondColumn, $firstValue, $secondValue): Builder
    {
        return $baseBuilder
            ->where(function (Builder $builder) use ($firstColumn, $secondColumn, $firstValue, $secondValue) {
                $builder
                    ->whereBetween($firstColumn, [$firstValue, $secondValue])
                    ->orWhereBetween($secondColumn, [$firstValue, $secondValue])
                    ->orWhere(function (Builder $builder) use ($firstColumn, $secondColumn, $firstValue, $secondValue) {
                        $builder
                            ->where($firstColumn, '<=', $firstValue)
                            ->where($secondColumn, '>=', $secondValue);
                    });
            });
    }
}