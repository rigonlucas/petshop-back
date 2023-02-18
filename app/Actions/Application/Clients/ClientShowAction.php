<?php

namespace App\Actions\Application\Clients;

use App\Actions\Application\Clients\DTO\ClientShowData;
use App\Actions\BaseAction;
use App\Actions\Traits\HasEagerLoading;
use App\Models\Clients\Client;
use Illuminate\Database\Eloquent\Model;

class ClientShowAction extends BaseAction
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