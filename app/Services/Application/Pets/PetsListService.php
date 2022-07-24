<?php

namespace App\Services\Application\Pets;

use App\Models\Pet;
use App\Services\Application\Pets\DTO\PetListData;
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

    public function accountPets(PetListData $data): self
    {
        $this->pets = Pet::query();
        $this->setRequestedIncludes(explode(',', $data->include));
        $this->setDefaultInclude(['breed']);

        $this->pets->when(
            $data->name,
            function ($query) use ($data) {
                $query->where('name', 'like', '%'. $data->name . '%');
            }
        );

        $this->pets->when(
            $data->client_id,
            function ($query) use ($data) {
                $query->where('account_id', $data->client_id);
            }
        );
        return $this;
    }

    public function getQuery(): Builder
    {
        $this->applyIncludesEagerLoading($this->pets);
        return $this->pets;
    }
}