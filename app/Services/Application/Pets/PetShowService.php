<?php

namespace App\Services\Application\Pets;

use App\Models\Clients\Pet;
use App\Services\Application\Pets\DTO\PetShowData;
use App\Services\BaseService;
use App\Services\Traits\HasEagerLoadingIncludes;
use Illuminate\Database\Eloquent\Model;

class PetShowService extends BaseService
{
    use HasEagerLoadingIncludes;

    function eagerIncludesRelations(): array
    {
        return [
            'registers' => [
                'registers'
            ],
            'breed' => [
                'breed'
            ]
        ];
    }

    public function show(PetShowData $data): Pet|Model
    {
        $query = Pet::byAccount($data->account_id);
        $this->applyIncludesEagerLoading($query);
        return $query->findOrFail($data->id);
    }
}