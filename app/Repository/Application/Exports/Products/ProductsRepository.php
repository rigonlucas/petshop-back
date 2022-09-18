<?php

namespace App\Repository\Application\Exports\Products;

use App\Models\User;
use App\Repository\interfaces\ExportQueryInterface;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;

class ProductsRepository implements ExportQueryInterface
{
    private Builder $query;

    public function __construct(User $user)
    {
        $this->query = DB::table('products')
            ->select([
                'products.id',
                'products.name',
                'products.description',
                'products.type',
                'products.cost',
                'products.price',
            ])
            ->addSelect(DB::raw('count(schedules_has_products.id) as products_schedule_count'))
            ->leftJoin(
                'schedules_has_products',
                'products.id',
                '=',
                'schedules_has_products.product_id'
            )
            ->where('account_id', '=', $user->account_id)
            ->groupBy('products.id');
    }

    public function getQuery(): Builder
    {
        return $this->query;
    }
}