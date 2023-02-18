<?php

namespace App\Actions\Application\Products;

use App\Actions\Application\Products\DTO\ProductShowData;
use App\Actions\BaseAction;
use App\Models\Products\Product;
use Illuminate\Database\Eloquent\Model;

class ProductShowAction extends BaseAction
{

    public function show(ProductShowData $data): Product|Model
    {
        $query = Product::byAccount($data->account_id);

        return $query->findOrFail($data->id);
    }
}