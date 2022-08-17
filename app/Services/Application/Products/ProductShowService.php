<?php

namespace App\Services\Application\Products;

use App\Models\Products\Product;
use App\Services\Application\Products\DTO\ProductShowData;
use App\Services\BaseService;
use App\Services\Traits\HasEagerLoading;
use Illuminate\Database\Eloquent\Model;

class ProductShowService extends BaseService
{

    public function show(ProductShowData $data): Product|Model
    {
        $query = Product::byAccount($data->account_id);

        return $query->findOrFail($data->id);
    }
}