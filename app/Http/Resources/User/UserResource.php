<?php

namespace App\Http\Resources\User;

use App\Http\Resources\Account\AccountResource;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'account_id' => $this->account_id,
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at,
            "deleted_at" => $this->deleted_at,
            "account" => new AccountResource($this->whenLoaded('account')),
        ];
    }
}
