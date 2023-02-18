<?php

namespace App\Actions\Application\Products;

use App\Actions\Application\Products\DTO\ProductUpdateData;
use App\Actions\BaseAction;
use App\Enums\ProductsEnum;
use App\Models\Products\Product;
use App\Rules\AccountHasEntityRule;
use App\Rules\Product\ProductAccountExistsRule;
use App\Rules\Product\ProductPriceRule;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Validation\ValidationException;

class ProductUpdateAction extends BaseAction
{

    /**
     * @throws ValidationException
     */
    public function update(ProductUpdateData $data): int
    {
        $this->validate($data);
        return Product::byAccount($data->account_id)
            ->where('id', '=', $data->id)
            ->update($data->except('validate')
                ->toArray()
            );
    }

    /**
     * @throws ValidationException
     */
    private function validate(ProductUpdateData $data): void
    {
        Validator::make(
            $data->toArray(),
            [
                'id' => [
                    'required',
                    'integer',
                    'min:1',
                    new ProductAccountExistsRule($data->account_id),
                    new AccountHasEntityRule(Product::class, $data->account_id),
                ],
                'name' => ['required', 'string', 'min:3', 'max:500'],
                'description' => ['nullable', 'string', 'min:3', 'max:500'],
                'type' => ['required', 'int', 'min:1', new Enum(ProductsEnum::class)],
                'cost' => ['required', 'numeric', 'gt:0', 'min:0'],
                'price' => ['required', 'numeric', 'gt:0', 'min:0', new ProductPriceRule($data->cost)],
                'validate' => ['nullable', 'date_format:Y-m-d']
            ]
        )->validate();
    }
}