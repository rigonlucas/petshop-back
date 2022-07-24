<?php

namespace App\Services\Application\Clients;

use App\Models\Client;
use App\Services\Application\Clients\DTO\ClientListData;
use App\Services\BaseService;
use App\Services\Traits\HasEagerLoadingIncludes;
use Illuminate\Database\Eloquent\Builder;

class ClientListService extends BaseService
{
    use HasEagerLoadingIncludes;

    private Builder $client;

    protected function eagerIncludesRelations(): array
    {
        return [
            'account' => [
                'account',
            ],
            'pets' => [
                'pets.breed',
            ]
        ];
    }

    public function accountClients(ClientListData $data): self
    {
        $this->client = Client::query();
        $this->setRequestedIncludes(explode(',', $data->include));
        $this->client->when(
            $data->name,
            function ($query) use ($data) {
                $query->where('name', 'like', '%'. $data->name . '%');
            }
        );

        $this->client->when(
            $data->order_by,
            function ($query) use ($data) {
                $query->orderBy('name');
            }
        );
        $this->applyIncludesEagerLoading($this->client);
        return $this;
    }

    public function getQuery(): Builder
    {
        return $this->client;
    }

}