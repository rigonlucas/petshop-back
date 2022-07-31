<?php

namespace App\Services\Application\Clients;

use App\Models\Clients\Client;
use App\Rules\AccountHasEntityRule;
use App\Rules\Client\ClientEmailExistsRule;
use App\Rules\Client\ClientNameExistsRule;
use App\Services\Application\Clients\DTO\ClientStoreData;
use App\Services\BaseService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class ClientStoreService extends BaseService
{
    public function store(ClientStoreData $data): Client|Model
    {
        $this->validate($data);
        $query = Client::byAccount($data->account_id);
        return $query->create($data->toArray());
    }

    private function validate(ClientStoreData $data)
    {
        Validator::make($data->toArray(), [
            'account_id' => [
                'required',
                'int',
                'min:1',
                new AccountHasEntityRule(Client::class, $data->account_id),
            ],
            'name' => [
                'required',
                'string',
                'min:1',
                'max:500',
                new ClientNameExistsRule($data->account_id)
            ],
            'email' => [
                'nullable',
                'email',
                new ClientEmailExistsRule($data->account_id)
            ],
            'phone' => ['nullable', 'string', 'max:100'],
        ])->validate();
    }
}