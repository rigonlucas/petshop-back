<?php

namespace App\Actions\Application\Vaccines;

use App\Actions\Application\Vaccines\DTO\VaccinesListData;
use App\Actions\BaseAction;
use App\Actions\Filters\ApplyFilters;
use App\Actions\Filters\Rules\WhereLikeFilter;
use App\Actions\Ordinations\ApplyOrdination;
use App\Actions\Ordinations\OrderBy;
use App\Actions\Traits\HasOrderBy;
use App\Models\Products\Vaccine;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class VaccinesListAction extends BaseAction
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

    public function list(VaccinesListData $data): Collection
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

        return $query->get();
    }
}