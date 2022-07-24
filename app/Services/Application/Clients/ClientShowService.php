<?php

namespace App\Services\Application\Clients;

use App\Models\Client;
use App\Services\BaseService;
use App\Services\Traits\HasEagerLoadingIncludes;
use Illuminate\Database\Eloquent\Builder;

class ClientShowService extends BaseService
{
    use HasEagerLoadingIncludes;

    private Builder $client;

    function eagerIncludesRelations(): array
    {
        return [
            'pets' =>[
                'pets.breed'
            ]
        ];
    }

    public function accountClient(int $id): self
    {
        $this->client = Client::query()->whereId($id);
        return $this;
    }

    public function getQuery(): Builder
    {
        $this->applyIncludesEagerLoading($this->client);
        return $this->client;
    }
}