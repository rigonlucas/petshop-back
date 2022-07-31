<?php

namespace App\Rules\Client;

use App\Models\Clients\Client;
use Illuminate\Contracts\Validation\Rule;

class ClientNameExistsOnUpdateRule implements Rule
{
    public function __construct(private readonly int $accountId, private readonly int $clientId)
    {
    }

    public function passes($attribute, $value)
    {
        return Client::byAccount($this->accountId)
            ->where('id', '!=', $this->clientId)
            ->where('name', '=', $value)
            ->doesntExist();
    }


    public function message()
    {
        return 'O nome do cliente já existe';
    }
}
