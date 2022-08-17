<?php

namespace App\Services\Application\Clients;

use App\Models\Clients\Client;
use App\Services\Application\Clients\DTO\ClientShowData;
use App\Services\BaseService;
use App\Services\Traits\HasEagerLoading;
use Illuminate\Database\Eloquent\Model;

class ClientShowService extends BaseService
{
    use HasEagerLoading;


    private array $relationsAvailables = [
        'pets',
        'account',
    ];

    public function show(ClientShowData $data): Client|Model
    {
        $query = Client::byAccount($data->account_id);
        $this->applyEagerLoadging($query, $data->include, $this->relationsAvailables);
        return $query->findOrFail($data->id);
    }
}