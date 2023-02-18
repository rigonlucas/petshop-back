<?php

namespace App\Actions\Application\Clients;

use App\Actions\Application\Clients\DTO\ClientDeleteData;
use App\Actions\BaseAction;
use App\Models\Clients\Client;
use App\Rules\AccountHasEntityRule;
use Illuminate\Support\Facades\Validator;

class ClientDeleteAction extends BaseAction
{
    public function delete(ClientDeleteData $data): int
    {
        $this->validate($data);
        $query = Client::byAccount($data->account_id)
            ->where('id', '=', $data->id);
        return $query->delete();
    }

    private function validate(ClientDeleteData $data)
    {
        Validator::make($data->toArray(), [
            "id" => [
                'required',
                'int',
                'min:1',
                new AccountHasEntityRule(Client::class, $data->account_id),
            ],
        ])->validate();
    }
}