<?php

namespace App\Services\Application\Products;

use App\Models\Products\Product;
use App\Services\Application\Products\DTO\ProductListData;
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

    public function accountProducts(ProductListData $data): self
    {
        $this->setOrderBy($data->order_by, $data->order_direction);
        $this->products = Product::query();
        $this->products->orderBy($this->orderBy, $this->orderDirection);
        return $this;
    }

    public function appliesOrderBy(): self
    {
        return $this;
    }

    public function getQuery(): Builder
    {
        return $this->products;
    }
}