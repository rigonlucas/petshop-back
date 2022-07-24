<?php

namespace App\Http\Resources\User;

use App\Http\Resources\Account\AccountResource;
use App\Support\AppJsonResource;

class UserResource extends AppJsonResource
{
    protected array $availableIncludes = ['account'];

    function resource($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'account_id' => $this->account_id,
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at,
            "deleted_at" => $this->when($this->deleted_at, $this->deleted_at)
        ];
    }

    public function includeAccount(): AccountResource
    {
        return AccountResource::make($this->account);
    }
}
