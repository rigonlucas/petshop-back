<?php

namespace App\Services\Application\Pets;

use App\Models\Clients\Pet;
use App\Services\Application\Pets\DTO\PetListData;
use App\Services\BaseService;
use App\Services\Filters\ApplyFilters;
use App\Services\Filters\Rules\WhereEqualFilter;
use App\Services\Filters\Rules\WhereLikeFilter;
use Illuminate\Contracts\Pagination\Paginator;

class PetListService extends BaseService
{

    public function list(PetListData $data): Paginator
    {
        $includes = explode(',', $data->include);
        $pets = Pet::query()->with($includes);
        $filters = [
            'client_id' => new WhereEqualFilter('client_id'),
            'name' => new WhereLikeFilter('name')
        ];
        ApplyFilters::apply($pets, $filters, $data->toArray());

        $pets->when(
            $data->name,
            function ($query) use ($data) {
                $query->where('name', 'like', '%' . $data->name . '%');
            }
        );
        return $pets->simplePaginate($data->per_page);
    }
}