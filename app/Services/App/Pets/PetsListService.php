<?php

namespace App\Services\App\Pets;

use App\Models\Pet;
use App\Services\BaseService;
use App\Services\Traits\HasEagerLoadingIncludes;
use Illuminate\Database\Eloquent\Builder;

class PetsListService extends BaseService
{
    use HasEagerLoadingIncludes;

    private Builder $pets;

    function eagerIncludesRelations(): array
    {
        return [
            'client' => [
                'client'
            ],
            'breed' => [
                'breed'
            ]
        ];
    }

    public function accountPets(): self
    {
        $this->pets = Pet::query();
        $this->setDefaultInclude(['breed']);
        return $this;
    }

    public function filterByName(?string $name): self
    {
        if ($name) {
            $this->pets->where('name', 'like', '%'. $name . '%');
        }
        return $this;
    }

    public function getQuery(): Builder
    {
        $this->applyIncludesEagerLoading($this->pets);
        return $this->pets;
    }

    public function filterByClient(?int $clientId): self
    {
        if ($clientId) {
            $this->pets->where('account_id', $clientId);
        }
        return $this;
    }
}