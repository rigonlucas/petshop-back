<?php

namespace App\Http\Resources\Pet\Registers;

use Illuminate\Http\Resources\Json\JsonResource;

class RegistersResource extends JsonResource
{
    function toArray($request)
    {
        return [
            'id' => $this->id,
            'pet_id' => $this->pet_id,
            'register' => $this->register,
            'type' => $this->type,
            'created_at' => $this->created_at
        ];
    }
}
