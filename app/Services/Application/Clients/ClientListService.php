<?php

namespace App\Services\Application\Clients;

use App\Models\Clients\Client;
use App\Services\Application\Clients\DTO\ClientListData;
use App\Services\BaseService;
use App\Services\Traits\HasEagerLoadingIncludes;
use Illuminate\Pagination\LengthAwarePaginator;

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

    public function list(ClientListData $data, int $accountId): LengthAwarePaginator
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

        return $query->paginate($data->per_page);
    }
}