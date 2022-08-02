<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Database\Eloquent\Model;

class AccountHasEntityTrashedRule implements Rule
{
    private Model $entityModel;

    public function __construct(private string $modelClassName, private int $accountId)
    {
        $this->entityModel = app($this->modelClassName);
    }

    public function passes($attribute, $value): bool
    {
        return $this->entityModel->newQuery()
            ->onlyTrashed()
            ->where('id', '=', $value)
            ->where('account_id', '=', $this->accountId)
            ->exists();
    }

    public function message()
    {
        return 'Registro não encontrado';
    }
}
