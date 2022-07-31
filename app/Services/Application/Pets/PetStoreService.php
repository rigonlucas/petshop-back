<?php

namespace App\Services\Application\Pets;

use App\Models\Clients\Client;
use App\Models\Clients\Pet;
use App\Models\Types\Breed;
use App\Rules\AccountHasEntityRule;
use App\Services\Application\Pets\DTO\PetStoreData;
use App\Services\BaseService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class PetStoreService extends BaseService
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
                'birthday' => ['required', 'date_format:Y-m-d', 'before:today'],
            ]
        )->validate();
    }
}