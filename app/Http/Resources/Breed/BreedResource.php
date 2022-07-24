<?php

namespace App\Http\Resources\Breed;

use App\Support\AppJsonResource;

class BreedResource extends AppJsonResource
{
    function resource($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'type' => $this->type
        ];
    }
}
