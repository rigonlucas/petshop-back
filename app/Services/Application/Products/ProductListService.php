<?php

namespace App\Services\Application\Products;

use App\Models\Product;
use App\Services\BaseService;
use App\Services\Traits\HasOrderBy;
use Illuminate\Database\Eloquent\Builder;

class ProductListService extends BaseService
{
    use HasOrderBy;

    private Builder $products;

    public function __construct()
    {
        $this->setAvailableColumns();
    }

    protected function setAvailableColumns()
    {
        $this->availableColumns = [
            'name',
            'type',
            'price',
            'cost_price',
            'created_at',
            'updated_at',
        ];
    }

    public function accountProducts(): self
    {
        $this->products = Product::query();
        return $this;
    }

    public function appliesOrderBy(): self
    {
        $this->products->orderBy($this->orderBy, $this->orderDirection);
        return $this;
    }

    public function getQuery(): Builder
    {
        return $this->products;
    }
}