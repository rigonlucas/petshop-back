<?php

namespace App\Http\Resources\Client;

use App\Http\Resources\Account\AccountResource;
use App\Http\Resources\Pet\PetResource;
use App\Http\Resources\Schedules\SchedulesResource;
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
            "pets" => PetResource::collection($this->whenLoaded('pets')),
            "schedules" => SchedulesResource::collection($this->whenLoaded('schedules')),
            "schedules_count" => $this->when($this->schedules_count, $this->schedules_count),
            "account" => new AccountResource($this->whenLoaded('account')),
        ];
    }
}
