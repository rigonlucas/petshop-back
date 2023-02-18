<?php

namespace App\Actions\Application\Products;

use App\Actions\Application\Products\DTO\ProductDeleteData;
use App\Actions\BaseAction;
use App\Models\Products\Product;
use App\Rules\AccountHasEntityRule;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class ProductDeleteAction extends BaseAction
{

    /**
     * @throws ValidationException
     */
    public function delete(ProductDeleteData $data): int
    {
        $this->validate($data);
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
                    new AccountHasEntityRule(Product::class, $data->account_id)
                ]
            ]
        )->validate();
    }
}