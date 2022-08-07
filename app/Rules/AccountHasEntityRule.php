<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Database\Eloquent\Model;

class AccountHasEntityRule implements Rule
{
    private Model $entityModel;

    public function __construct(private readonly string $modelClassName, private readonly int $accountId)
    {
        $this->entityModel = app($this->modelClassName);
    }

    public function passes($attribute, $value): bool
    {
        return $this->entityModel->newQuery()
            ->where('id', '=', $value)
            ->where('account_id', '=', $this->accountId)
            ->exists();
    }

    public function message()
    {
        return 'Registro não encontrado';
    }
}
