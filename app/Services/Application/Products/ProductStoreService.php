<?php

namespace App\Services\Application\Products;

use App\Enums\ProductsEnum;
use App\Models\Products\Product;
use App\Models\Products\ProductPrice;
use App\Rules\Product\ProductPriceRule;
use App\Services\Application\Products\DTO\ProductStoreData;
use App\Services\BaseService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Validation\ValidationException;

class ProductStoreService extends BaseService
{

    /**
     * @throws ValidationException
     */
    public function store(ProductStoreData $data): Model|Builder
    {
        $this->validate($data);
        $product = Product::byAccount($data->account_id)->create($data->except('validate')->toArray());
        ProductPrice::query()
            ->create([
                'product_id' => $product->id,
                'cost_price' => $product->cost_price,
                'price' => $product->price,
                'validate' => $data->validate
            ]);
        return $product;
    }

    /**
     * @throws ValidationException
     */
    private function validate(ProductStoreData $data): void
    {
        Validator::make(
            $data->toArray(),
            [
                'name' => ['required', 'string', 'min:3', 'max:500'],
                'description' => ['required', 'string', 'min:3', 'max:500'],
                'type' => ['required', 'int', 'min:1', new Enum(ProductsEnum::class)],
                'cost_price' => ['required', 'numeric', 'gt:0', 'min:0'],
                'price' => ['required', 'numeric', 'gt:0', 'min:0', new ProductPriceRule($data->cost_price)],
                'account_id' => ['required', 'int', 'min:1', 'exists:accounts,id'],
                'validate' => ['nullable', 'date_format:Y-m-d']
            ]
        )->validate();
    }
}