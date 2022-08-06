<?php

namespace App\Services\Application\PetsRegisters;

use App\Enums\PetRegisterTypesEnum;
use App\Models\Clients\Pet;
use App\Models\Clients\PetRegisters;
use App\Rules\AccountHasEntityRule;
use App\Services\Application\PetsRegisters\DTO\PetRegisterStoreData;
use App\Services\BaseService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Validation\ValidationException;

class PetRegisterStoreService extends BaseService
{

    /**
     * @throws ValidationException
     */
    public function store(PetRegisterStoreData $data): Model|Builder
    {
        $this->validate($data);
        return PetRegisters::query()
            ->where('pet_id', '=', $data->pet_id)
            ->create($data->toArray());
    }

    /**
     * @throws ValidationException
     */
    private function validate(PetRegisterStoreData $data): void
    {
        Validator::make(
            $data->toArray(),
            [
                'register' => ['required', 'string', 'min:3', 'max:500'],
                'pet_id' => [
                    'required',
                    'integer',
                    'min:1',
                    new AccountHasEntityRule(Pet::class, $data->account_id),
                ],
                'type' => [
                    'required',
                    'numeric',
                    'gt:0',
                    'min:1',
                    new Enum(PetRegisterTypesEnum::class)
                ],
            ]
        )->validate();
    }
}