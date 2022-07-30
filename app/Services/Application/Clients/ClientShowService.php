<?php

namespace App\Services\Application\Clients;

use App\Models\Clients\Client;
use App\Services\BaseService;
use App\Services\Traits\HasEagerLoadingIncludes;
use Illuminate\Database\Eloquent\Model;

class ClientShowService extends BaseService
{
    use HasEagerLoadingIncludes;

    function eagerIncludesRelations(): array
    {
        return [
            'pets' =>[
                'pets.breed'
            ]
        ];
    }

    public function show(int $id): Client|Model
    {
        $query = Client::query();
        $this->applyIncludesEagerLoading($query);

        return $query->findOrFail($id);
    }
}