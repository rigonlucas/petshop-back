<?php

namespace App\Actions\Application\Clients;

use App\Actions\Application\Clients\DTO\ClientUpdateData;
use App\Actions\BaseAction;
use App\Models\Clients\Client;
use App\Rules\AccountHasEntityRule;
use App\Rules\Client\ClientEmailExistsOnUpdateRule;
use App\Rules\Client\ClientNameExistsOnUpdateRule;
use Illuminate\Support\Facades\Validator;

class ClientUpdateAction extends BaseAction
{
    public function update(ClientUpdateData $data): int
    {
        $this->validate($data);
        $data = $this->normalizeData($data);
        $query = Client::byAccount($data->account_id)
            ->where('id', '=', $data->id);
        return $query->update($data->toArray());
    }

    private function validate(ClientUpdateData $data)
    {
        Validator::make($data->toArray(), [
            "id" => [
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
                new ClientNameExistsOnUpdateRule($data->account_id, $data->id)
            ],
            'email' => [
                'nullable',
                'email',
                new ClientEmailExistsOnUpdateRule($data->account_id, $data->id)
            ],
            'phone' => ['nullable', 'string', 'max:100'],
        ])->validate();
    }


    private function normalizeData(ClientUpdateData $data): ClientUpdateData
    {
        $data->email = strtolower($data->email);
        $data->name = ucwords(strtolower($data->name));
        return $data;
    }
}