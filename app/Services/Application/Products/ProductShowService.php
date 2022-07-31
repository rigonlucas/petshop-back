<?php

namespace App\Services\Application\Products;

use App\Models\Products\Product;
use App\Services\Application\Products\DTO\ProductShowData;
use App\Services\BaseService;
use App\Services\Traits\HasEagerLoadingIncludes;
use Illuminate\Database\Eloquent\Model;

class ProductShowService extends BaseService
{
    use HasEagerLoadingIncludes;

    function eagerIncludesRelations(): array
    {
        return [
            'prices' =>[
                'prices'
            ]
        ];
    }

    public function show(ProductShowData $data): Product|Model
    {
        $query = Product::byAccount($data->account_id);
        $this->applyIncludesEagerLoading($query);

        return $query->findOrFail($data->id);
    }
}