<?php

namespace App\Services\Application\Pets;

use App\Models\Clients\Pet;
use App\Services\Application\Pets\DTO\PetShowData;
use App\Services\BaseService;
use App\Services\Traits\HasEagerLoading;
use Illuminate\Database\Eloquent\Model;

class PetShowService extends BaseService
{
    use HasEagerLoading;

    private array $relationsAvailables = [
        'client',
        'breed',
    ];

    public function show(PetShowData $data): Pet|Model
    {
        $query = Pet::byAccount($data->account_id);
        $this->applyEagerLoadging($query, $data->include, $this->relationsAvailables);
        return $query->findOrFail($data->id);
    }
}