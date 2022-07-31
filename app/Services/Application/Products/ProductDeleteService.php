<?php

namespace App\Services\Application\Products;

use App\Models\Products\Product;
use App\Models\Products\ProductPrice;
use App\Rules\AccountHasEntityRule;
use App\Rules\Product\ProductAccountExistsRule;
use App\Services\Application\Products\DTO\ProductDeleteData;
use App\Services\BaseService;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class ProductDeleteService extends BaseService
{

    /**
     * @throws ValidationException
     */
    public function delete(ProductDeleteData $data): int
    {
        $this->validate($data);
        $this->updateProductPrices($data);
        return Product::byAccount($data->account_id)->find($data->id)->delete();
    }

    /**
     * @throws ValidationException
     */
    private function validate(ProductDeleteData $data): void
    {
        Validator::make(
            $data->toArray(),
            [
                'id' => [
                    'required',
                    'integer',
                    'min:1',
                    new ProductAccountExistsRule($data->account_id),
                    new AccountHasEntityRule(Product::class, $data->account_id)
                ]
            ]
        )->validate();
    }

    private function updateProductPrices(ProductDeleteData $data): void
    {
        ProductPrice::query()
            ->where('product_id', '=', $data->id)
            ->update(['activated_at' => null]);
    }
}