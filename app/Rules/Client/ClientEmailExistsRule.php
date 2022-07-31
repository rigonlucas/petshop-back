<?php

namespace App\Rules\Client;

use App\Models\Clients\Client;
use Illuminate\Contracts\Validation\Rule;

class ClientEmailExistsRule implements Rule
{
    public function __construct(private readonly int $accountId)
    {
    }

    public function passes($attribute, $value)
    {
        return Client::byAccount($this->accountId)
            ->where('email', '=', $value)
            ->doesntExist();
    }

    public function message()
    {
        return 'Este email já está sendo utilizado';
    }
}
