<?php

namespace App\Actions\Application\Breeds;

use App\Actions\Application\Breeds\DTO\BreedListData;
use App\Actions\BaseAction;
use App\Models\Types\Breed;
use Illuminate\Database\Eloquent\Builder;

class BreedsListAction extends BaseAction
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