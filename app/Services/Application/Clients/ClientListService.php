<?php

namespace App\Services\Application\Clients;

use App\Models\Clients\Client;
use App\Services\Application\Clients\DTO\ClientListData;
use App\Services\BaseService;
use App\Services\Traits\HasEagerLoadingIncludes;

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
            ],
            'registers' => [
                'pets.registers'
            ]
        ];
    }

    public function list(ClientListData $data, int $accountId): \Illuminate\Contracts\Pagination\Paginator
    {
        $query = Client::byAccount($accountId);

        $this->setRequestedIncludes(explode(',', $data->include));
        $this->applyIncludesEagerLoading($query);

        $query->when(
            $data->name,
            function ($query) use ($data) {
                $query->where('name', 'like', '%'. $data->name . '%');
            }
        );

        $query->when(
            $data->order_by,
            function ($query) use ($data) {
                $query->orderBy('name');
            }
        );

        return $query->simplePaginate($data->per_page);
    }
}