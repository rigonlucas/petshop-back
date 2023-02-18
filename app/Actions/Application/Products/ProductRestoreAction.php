<?php

namespace App\Actions\Application\Products;

use App\Actions\Application\Products\DTO\ProductRestoreData;
use App\Actions\BaseAction;
use App\Models\Products\Product;
use App\Models\Products\ProductPrice;
use App\Rules\AccountHasEntityTrashedRule;
use App\Rules\Product\DeletedProductAccountExistsRule;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class ProductRestoreAction extends BaseAction
{

    /**
     * @throws ValidationException
     */
    public function restore(ProductRestoreData $data): int
    {
        $this->validate($data);
        $this->updateProductPrices($data);
        return Product::onlyTrashed()
            ->byAccount($data->account_id)
            ->where('id', '=', $data->id)
            ->restore();
    }

    /**
     * @throws ValidationException
     */
    private function validate(ProductRestoreData $data): void
    {
        Validator::make(
            $data->toArray(),
            [
                'id' => [
                    'required', 'integer', 'min:1',
                    new DeletedProductAccountExistsRule($data->account_id),
                    new AccountHasEntityTrashedRule(Product::class, $data->account_id)
                ]
            ]
        )->validate();
    }

    private function updateProductPrices(ProductRestoreData $data): void
    {
        ProductPrice::query()
            ->where('product_id', '=', $data->id)
            ->latest('created_at')
            ->limit(1)
            ->update(['activated_at' => now()]);
    }
}