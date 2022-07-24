<?php

namespace App\Services\App\Clients;

use App\Models\Client;
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

    public function accountClients(): self
    {
        $this->client = Client::query();
        $this->applyIncludesEagerLoading($this->client);
        return $this;
    }

    public function setOrderBy(): self
    {
        $this->client->orderBy('name');
        return $this;
    }

    public function getQuery(): Builder
    {
        return $this->client;
    }

}