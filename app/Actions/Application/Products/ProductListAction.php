<?php

namespace App\Actions\Application\Products;

use App\Actions\Application\Products\DTO\ProductListData;
use App\Actions\BaseAction;
use App\Actions\Filters\ApplyFilters;
use App\Actions\Filters\Rules\WhereLikeFilter;
use App\Actions\Ordinations\ApplyOrdination;
use App\Actions\Ordinations\OrderBy;
use App\Actions\Traits\HasOrderBy;
use App\Models\Products\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\CursorPaginator;

class ProductListAction extends BaseAction
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
        ApplyOrdination::apply($query, $ordination);

        return $query->cursorPaginate($data->per_page);
    }
}