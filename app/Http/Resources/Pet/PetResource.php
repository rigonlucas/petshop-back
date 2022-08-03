<?php

namespace App\Http\Resources\Pet;

use App\Http\Resources\Breed\BreedResource;
use App\Support\AppJsonResource;

class PetResource extends AppJsonResource
{
    protected array $availableIncludes = ['breed', 'client'];
    protected array $defaultIncludes = ['breed'];

    function resource($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'client_id' => $this->client_id
        ];
    }

    public function includeBreed(): BreedResource
    {
        return BreedResource::make($this->breed);
    }

    public function includeClient(): BreedResource
    {
        return BreedResource::make($this->client);
    }
}
