<?php

namespace App\Services\Application\Pets;

use App\Models\Clients\Pet;
use App\Rules\AccountHasEntityRule;
use App\Services\Application\Pets\DTO\PetDeleteData;
use App\Services\BaseService;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class PetDeleteService extends BaseService
{

    /**
     * @throws ValidationException
     */
    public function delete(PetDeleteData $data): int
    {
        $this->validate($data);
        return Pet::byAccount($data->account_id)
            ->find($data->id)
            ->delete();
    }

    /**
     * @throws ValidationException
     */
    private function validate(PetDeleteData $data): void
    {
        //dd((new AccountHasEntityRule(Pet::class, $data->account_id))->passes('', $data->id));
        Validator::make(
            $data->toArray(),
            [
                'id' => [
                    'required',
                    'integer',
                    'min:1',
                    new AccountHasEntityRule(Pet::class, $data->account_id),
                ],
                'account_id' => ['required', 'integer', 'min:1']
            ]
        )->validate();
    }
}