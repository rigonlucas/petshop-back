<?php

namespace App\Actions\Application\Pets;

use App\Actions\Application\Pets\DTO\PetListData;
use App\Actions\BaseAction;
use App\Actions\Filters\ApplyFilters;
use App\Actions\Filters\Rules\WhereEqualFilter;
use App\Actions\Filters\Rules\WhereLikeFilter;
use App\Models\Clients\Pet;
use Illuminate\Contracts\Pagination\Paginator;

class PetListAction extends BaseAction
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