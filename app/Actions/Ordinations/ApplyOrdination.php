<?php

namespace App\Actions\Ordinations;

use Illuminate\Database\Eloquent\Builder;
use InvalidArgumentException;

class ApplyOrdination
{
    public static function apply(Builder $builder, array $ordination): void
    {
        foreach ($ordination as $orderName => $order) {
            if (!($order instanceof OrdinationInterface)) {
                throw new InvalidArgumentException('Ordenação não implementa interface');
            }
            $order->orderBy(
                $builder,
                empty($orderName)
                    ? $builder->getModel()->getFillable()[0]
                    : $orderName
            );
        }

    }
}