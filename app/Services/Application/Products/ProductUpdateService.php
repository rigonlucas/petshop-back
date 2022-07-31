<?php

namespace App\Services\Application\Products;

use App\Enums\ProductsEnum;
use App\Models\Clients\Client;
use App\Models\Products\Product;
use App\Models\Products\ProductPrice;
use App\Rules\AccountHasEntityRule;
use App\Rules\Product\PriceWasModifiedRule;
use App\Rules\Product\ProductAccountExistsRule;
use App\Rules\Product\ProductPriceRule;
use App\Services\Application\Products\DTO\ProductUpdateData;
use App\Services\BaseService;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Validation\ValidationException;

class ProductUpdateService extends BaseService
{

    /**
     * @throws ValidationException
     */
    public function update(ProductUpdateData $data): int
    {
        $this->validate($data);
        $productQuery = Product::byAccount($data->account_id)
            ->where('id', '=', $data->id);
        /** @var Product $product */
        $product = clone $productQuery;
        $product = $product->first();
        $priceWasModified = new PriceWasModifiedRule($product, $data->cost_price);
        if ($priceWasModified->passes('price', $data->price)) {
            $this->createProductPrice($data);
        }
        return $productQuery->update($data->toArray());
    }

    /**
     * @throws ValidationException
     */
    private function validate(ProductUpdateData $data): void
    {
        Validator::make(
            $data->toArray(),
            [
                'id' => ['required', 'integer', 'min:1', new ProductAccountExistsRule($data->account_id)],
                'name' => ['required', 'string', 'min:3', 'max:500'],
                'description' => ['required', 'string', 'min:3', 'max:500'],
                'type' => ['required', 'int', 'min:1', new Enum(ProductsEnum::class)],
                'cost_price' => ['required', 'numeric', 'gt:0', 'min:0'],
                'price' => ['required', 'numeric', 'gt:0', 'min:0', new ProductPriceRule($data->cost_price)],
                'account_id' => [
                    'required',
                    'int',
                    'min:1',
                    new AccountHasEntityRule(Client::class, $data->account_id),
                ]
            ]
        )->validate();
    }

    private function createProductPrice(ProductUpdateData $data): void
    {
        ProductPrice::query()
            ->where('product_id', '=', $data->id)
            ->update(['activated_at' => null]);

        ProductPrice::query()
            ->create([
                'product_id' => $data->id,
                'cost_price' => $data->cost_price,
                'price' => $data->price,
            ]);
    }
}