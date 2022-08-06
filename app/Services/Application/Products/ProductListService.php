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

    public function list(ProductListData $data, int $accountId): \Illuminate\Contracts\Pagination\Paginator
    {
        $this->setOrderBy($data->order_by, $data->order_direction);
        return Product::byAccount($accountId)
            ->orderBy($this->orderBy, $this->orderDirection)->simplePaginate($data->per_page);
    }
}