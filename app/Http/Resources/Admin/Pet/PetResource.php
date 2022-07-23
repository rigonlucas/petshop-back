<?php

namespace App\Http\Resources\Admin\Pet;

use App\Http\Resources\Admin\Breed\BreedResource;
use App\Support\AppJsonResource;

class PetResource extends AppJsonResource
{
    protected array $availableIncludes = ['breed'];
    protected array $defaultIncludes = ['breed'];

    function resource($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
        ];
    }

    public function includeBreed(): BreedResource
    {
        return BreedResource::make($this->breed);
    }

}
