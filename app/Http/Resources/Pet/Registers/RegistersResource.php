<?php

namespace App\Http\Resources\Pet\Registers;

use App\Support\AppJsonResource;

class RegistersResource extends AppJsonResource
{
    function resource($request)
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
