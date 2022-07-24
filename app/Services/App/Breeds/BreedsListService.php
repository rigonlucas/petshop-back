<?php

namespace App\Services\App\Breeds;

use App\Models\Breed;
use App\Services\BaseService;
use Illuminate\Database\Eloquent\Builder;

class BreedsListService extends BaseService
{

    private Builder $breeds;

    public function breeds(): self
    {
        $this->breeds = Breed::query();
        return $this;
    }

    public function filterByType(?string $type): self
    {
        if ($type) {
            $this->breeds->whereType($type);
        }
        return $this;
    }

    public function getQuery(): Builder
    {
        return $this->breeds;
    }
}