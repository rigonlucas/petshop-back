<?php

namespace App\Services\Application\Breeds;

use App\Models\Breed;
use App\Services\Application\Breeds\DTO\AccountUserListData;
use App\Services\BaseService;
use Illuminate\Database\Eloquent\Builder;

class BreedsListService extends BaseService
{

    private Builder $breeds;

    public function breeds(AccountUserListData $data): self
    {
        $this->breeds = Breed::query();
        $this->breeds->when(
            $data->type,
            function ($query) use ($data) {
                $query->whereType($data->type);
            }
        );
        return $this;
    }

    public function getQuery(): Builder
    {
        return $this->breeds;
    }
}