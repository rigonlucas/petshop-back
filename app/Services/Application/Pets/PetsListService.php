<?php

namespace App\Services\Application\Pets;

use App\Models\Clients\Pet;
use App\Services\Application\Pets\DTO\PetListData;
use App\Services\BaseService;
use App\Services\Traits\HasEagerLoadingIncludes;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;

class PetsListService extends BaseService
{
    use HasEagerLoadingIncludes;

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

    public function list(PetListData $data): LengthAwarePaginator
    {
        $pets = Pet::query();
        $this->setRequestedIncludes(explode(',', $data->include));
        $this->setDefaultInclude(['breed']);
        $this->applyIncludesEagerLoading($pets);

        $pets->when(
            $data->name,
            function ($query) use ($data) {
                $query->where('name', 'like', '%'. $data->name . '%');
            }
        );

        $pets->when(
            $data->client_id,
            function ($query) use ($data) {
                $query->where('account_id', $data->client_id);
            }
        );
        return $pets->paginate($data->per_page ?? 10);
    }
}