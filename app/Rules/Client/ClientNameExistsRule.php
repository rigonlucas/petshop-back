<?php

namespace App\Rules\Client;

use App\Models\Clients\Client;
use Illuminate\Contracts\Validation\Rule;

class ClientNameExistsRule implements Rule
{
    public function __construct(private readonly int $accountId)
    {
    }

    public function passes($attribute, $value)
    {
        return Client::byAccount($this->accountId)
            ->where('name', '=', $value)
            ->doesntExist();
    }


    public function message()
    {
        return 'O nome do cliente já existe';
    }
}
