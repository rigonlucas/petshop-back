<?php

namespace App\Actions\Application\Pets;

use App\Actions\Application\Pets\DTO\PetDeleteData;
use App\Actions\BaseAction;
use App\Models\Clients\Pet;
use App\Rules\AccountHasEntityRule;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class PetDeleteAction extends BaseAction
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