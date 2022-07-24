<?php

namespace App\Http\Resources\Client;

use App\Http\Resources\Account\AccountResource;
use App\Http\Resources\Pet\PetResource;
use App\Support\AppJsonResource;

class ClientResource extends AppJsonResource
{
    protected array $availableIncludes = ['pets', 'account'];

    function resource($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at,
            "deleted_at" => $this->when($this->deleted_at, $this->deleted_at)
        ];
    }

    public function includePets()
    {
        return PetResource::collection($this->pets);
    }

    public function includeAccount()
    {
        return AccountResource::make($this->account);
    }
}
