<?php

namespace App\Http\Resources\Pet;

use App\Http\Resources\Breed\BreedResource;
use App\Http\Resources\Client\ClientResource;
use Illuminate\Http\Resources\Json\JsonResource;

class PetResource extends JsonResource
{
    function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'client_id' => $this->client_id,
            "breed" => new BreedResource($this->whenLoaded('breed')),
            "client" => new ClientResource($this->whenLoaded('client')),
        ];
    }
}
