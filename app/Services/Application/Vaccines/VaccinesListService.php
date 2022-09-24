<?php

namespace App\Services\Application\Vaccines;

use App\Models\Products\Vaccine;
use App\Services\Application\Vaccines\DTO\VaccinesListData;
use App\Services\BaseService;
use App\Services\Filters\ApplyFilters;
use App\Services\Filters\Rules\WhereLikeFilter;
use App\Services\Ordinations\ApplyOrdination;
use App\Services\Ordinations\OrderBy;
use App\Services\Traits\HasOrderBy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\CursorPaginator;

class VaccinesListService extends BaseService
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
            'description',
            'type',
            'days_to_booster_dose',
            'created_at',
            'updated_at',
        ];
    }

    public function list(VaccinesListData $data): CursorPaginator
    {
        $query = Vaccine::query();
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