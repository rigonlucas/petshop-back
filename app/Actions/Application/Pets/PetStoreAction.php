<?php

namespace App\Actions\Application\Pets;

use App\Actions\Application\Pets\DTO\PetStoreData;
use App\Actions\BaseAction;
use App\Models\Clients\Client;
use App\Models\Clients\Pet;
use App\Rules\AccountHasEntityRule;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class PetStoreAction extends BaseAction
{

    /**
     * @throws ValidationException
     */
    public function store(PetStoreData $data): Model|Builder
    {
        $this->validate($data);
        return Pet::byAccount($data->account_id)
            ->create($data->toArray());
    }

    /**
     * @throws ValidationException
     */
    private function validate(PetStoreData $data): void
    {
        Validator::make(
            $data->toArray(),
            [
                'name' => ['required', 'string', 'min:3', 'max:500'],
                'client_id' => [
                    'required',
                    'int',
                    'min:1',
                    new AccountHasEntityRule(Client::class, $data->account_id),
                ],
                'breed_id' => ['required', 'numeric', 'gt:0', 'min:1', 'exists:breeds,id'],
                'birthday' => ['nullable', 'date_format:Y-m-d', 'before:today'],
            ]
        )->validate();
    }
}