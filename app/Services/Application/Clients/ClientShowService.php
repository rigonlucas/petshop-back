<?php

namespace App\Services\Application\Clients;

use App\Models\Clients\Client;
use App\Services\Application\Clients\DTO\ClientShowData;
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
                'pets.breed',
                'pets.registers'
            ]
        ];
    }

    public function show(ClientShowData $data): Client|Model
    {
        $query = Client::byAccount($data->account_id);
        $this->applyIncludesEagerLoading($query);
        return $query->findOrFail($data->id);
    }
}