<?php

namespace App\Http\Resources\Account;

use App\Http\Resources\User\UserResource;
use App\Support\AppJsonResource;

class AccountResource extends AppJsonResource
{
    protected array $availableIncludes = ['user'];

    function resource($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'user_id' => $this->user_id,
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at,
            "deleted_at" => $this->when($this->deleted_at, $this->deleted_at)
        ];
    }

    public function includeUser(): UserResource|null
    {
        return $this->user ? UserResource::make($this->user) : null;
    }
}
