<?php

namespace App\Http\Resources\Client;

use App\Http\Resources\Account\AccountResource;
use App\Http\Resources\Pet\PetResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ClientResource extends JsonResource
{
    function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at,
            "pet" => PetResource::collection($this->whenLoaded('pets')),
            "account" => new AccountResource($this->whenLoaded('account')),
        ];
    }
}
