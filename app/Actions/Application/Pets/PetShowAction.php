<?php

namespace App\Actions\Application\Pets;

use App\Actions\Application\Pets\DTO\PetShowData;
use App\Actions\BaseAction;
use App\Actions\Traits\HasEagerLoading;
use App\Models\Clients\Pet;
use Illuminate\Database\Eloquent\Model;

class PetShowAction extends BaseAction
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