<?php

namespace App\Services\App\Clients;

use App\Models\Client;
use App\Services\BaseService;
use App\Services\Traits\HasEagerLoadingIncludes;
use Illuminate\Database\Eloquent\Builder;

class ClientListService extends BaseService
{
    use HasEagerLoadingIncludes;

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

    public function accountClients(): Builder
    {
        $query = Client::query();
        $this->applyIncludesEagerLoading($query);
        return $query->orderBy('name');
    }

}