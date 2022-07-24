<?php

namespace App\Services\Application\Clients;

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
        return $this;
    }

    public function filterByName(?string $name): self
    {
        if ($name) {
            $this->client->where('name', 'like', '%'. $name . '%');
        }
        return $this;
    }

    public function setOrderBy(): self
    {
        $this->client->orderBy('name');
        return $this;
    }

    public function getQuery(): Builder
    {
        $this->applyIncludesEagerLoading($this->client);
        return $this->client;
    }

}