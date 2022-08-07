<?php

namespace App\Services\Application\Breeds;

use App\Models\Types\Breed;
use App\Services\Application\Breeds\DTO\BreedListData;
use App\Services\BaseService;
use Illuminate\Database\Eloquent\Builder;

class BreedsListService extends BaseService
{

    private Builder $breeds;

    public function list(BreedListData $data): \Illuminate\Contracts\Pagination\Paginator
    {
        $this->breeds = Breed::query();
        $this->breeds->when(
            $data->type,
            function ($query) use ($data) {
                $query->whereType($data->type);
            }
        );
        return $this->breeds->simplePaginate($data->per_page);
    }

    public function getQuery(): Builder
    {
        return $this->breeds;
    }
}