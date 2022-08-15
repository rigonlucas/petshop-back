<?php

namespace App\Http\Resources\Breed;

use Illuminate\Http\Resources\Json\JsonResource;

class BreedResource extends JsonResource
{
    function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'type' => $this->type,
        ];
    }
}
