<?php

namespace App\Services\Application\Pets;

use App\Models\Clients\Client;
use App\Models\Clients\Pet;
use App\Models\Products\ProductPrice;
use App\Rules\AccountHasEntityRule;
use App\Rules\Pet\PetBelongsToClientRule;
use App\Services\Application\Pets\DTO\PetUpdateData;
use App\Services\Application\Products\DTO\ProductUpdateData;
use App\Services\BaseService;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class PetUpdateService extends BaseService
{

    /**
     * @throws ValidationException
     */
    public function update(PetUpdateData $data): int
    {
        $this->validate($data);
        $pet = Pet::byAccount($data->account_id)
            ->where('id', '=', $data->id);
        return $pet->update($data->toArray());
    }

    /**
     * @throws ValidationException
     */
    private function validate(PetUpdateData $data): void
    {
        Validator::make(
            $data->toArray(),
            [
                'id' => [
                    'required',
                    'integer',
                    'min:1',
                    new AccountHasEntityRule(Pet::class, $data->account_id),
                    new PetBelongsToClientRule($data->client_id)
                ],
                'name' => ['required', 'string', 'min:3', 'max:500'],
                'client_id' => [
                    'required',
                    'int',
                    'min:1',
                    new AccountHasEntityRule(Client::class, $data->account_id)
                ],
                'breed_id' => ['required', 'numeric', 'gt:0', 'min:1', 'exists:breeds,id'],
                'birthday' => ['required', 'date_format:Y-m-d', 'before:today'],
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
                'cost' => $data->cost,
                'price' => $data->price,
            ]);
    }
}