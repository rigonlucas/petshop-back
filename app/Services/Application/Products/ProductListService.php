<?php

namespace App\Services\Application\Products;

use App\Models\Products\Product;
use App\Services\Application\Products\DTO\ProductListData;
use App\Services\BaseService;
use App\Services\Filters\ApplyFilters;
use App\Services\Filters\Rules\WhereLikeFilter;
use App\Services\Ordinations\ApplyOrdination;
use App\Services\Ordinations\OrderBy;
use App\Services\Traits\HasOrderBy;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\CursorPaginator;

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
            'cost',
            'created_at',
            'updated_at',
        ];
    }

    public function list(ProductListData $data, int $accountId): CursorPaginator
    {
        $query = Product::byAccount($accountId);
        $ordination = [
          $data->order_by => new OrderBy($data->order_direction)
        ];

        $filters = [
            'name' => new WhereLikeFilter('name'),
        ];
        ApplyFilters::apply($query, $filters, $data->toArray());
        ApplyOrdination::apply($query, $ordination, $data->toArray());
        $this->setOrderBy($data->order_by, $data->order_direction);
        return $query->orderBy($this->orderBy, $this->orderDirection)->cursorPaginate($data->per_page);
    }
}