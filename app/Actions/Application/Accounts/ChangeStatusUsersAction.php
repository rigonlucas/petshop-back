<?php

namespace App\Actions\Application\Accounts;

use App\Actions\BaseAction;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class ChangeStatusUsersAction extends BaseAction
{
    public function change(Mixed $user): void
    {
        if (!$user->deleted_at) {
            $user->tokens()->delete();
            $user->delete();
        } else {
            $this->validateRestore($user);
            $user->restore();
        }
    }

    public function findUser(int $id): Model|Collection|Builder|array|null
    {
        return User::withTrashed()->find($id);
    }

    private function validateRestore(mixed $user)
    {
        $dateToRestore = Carbon::createFromDate($user->deleted_at)->addDays(config('dates.restore_user.allow_in'));
        Validator::make(
            [
                'deleted_at' => $dateToRestore
            ],
            [
                'deleted_at' => [
                    'required',
                    'date',
                    'before_or_equal:' . Carbon::now()
                ],
            ],
            [
                'deleted_at.before_or_equal' => 'Para ativar a conta ainda é necessário aguarda até '
                    . $dateToRestore->format('d/m/Y')
                    . ', ou entre em contato com o suporte do sistema'
            ]
        )->validate();
    }
}