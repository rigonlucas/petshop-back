<?php

namespace App\Services\Application\PetsRegisters;

use App\Models\Clients\Pet;
use App\Models\Clients\PetRegisters;
use App\Rules\AccountHasEntityRule;
use App\Rules\Pet\PetRegisterBelongsToPetRule;
use App\Services\Application\PetsRegisters\DTO\PetRegisterDeleteData;
use App\Services\BaseService;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class PetRegisterDeleteService extends BaseService
{

    /**
     * @throws ValidationException
     */
    public function delete(PetRegisterDeleteData $data): int
    {
        $this->validate($data);
        return PetRegisters::query()
            ->find($data->id)
            ->delete();
    }

    /**
     * @throws ValidationException
     */
    private function validate(PetRegisterDeleteData $data): void
    {
        Validator::make(
            $data->toArray(),
            [
                'pet_id' => [
                    'required',
                    'integer',
                    'min:1',
                    new AccountHasEntityRule(Pet::class, $data->account_id),
                ],
                'id' => [
                    'required',
                    'integer',
                    'min:1',
                    new PetRegisterBelongsToPetRule($data->pet_id),
                ],
            ]
        )->validate();
    }
}