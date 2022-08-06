<?php

namespace App\Http\Resources\Pet;

use App\Http\Resources\Breed\BreedResource;
use App\Http\Resources\Pet\Registers\RegistersResource;
use App\Support\AppJsonResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class PetResource extends AppJsonResource
{
    protected array $availableIncludes = ['breed', 'registers'];
    protected array $defaultIncludes = [];

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

    public function includeRegisters(): AnonymousResourceCollection
    {
        return RegistersResource::collection($this->registers);
    }
}
