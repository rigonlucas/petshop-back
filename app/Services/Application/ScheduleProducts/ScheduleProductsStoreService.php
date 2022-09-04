<?php

namespace App\Services\Application\ScheduleProducts;

use App\Models\Schedules\Schedule;
use App\Models\User;
use App\Services\Application\ScheduleProducts\DTO\ScheduleProductsStoreData;
use App\Services\Application\Schedules\Validators\ScheduleProductsValidator;
use App\Services\BaseService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class ScheduleProductsStoreService extends BaseService
{

    public function store(ScheduleProductsStoreData $data, User $user): Collection
    {
        $data->account_id = $user->account_id;
        $this->validate($data);
        return DB::transaction(function () use ($data) {
            /** @var Schedule $schedule */
            $schedule = Schedule::byAccount($data->account_id)->with('products')->findOrFail($data->schedule_id);
            $this->productsInScheduleRule($data, $schedule);
            return $this->addProducts($data, $schedule);
        });
    }

    /**
     * @throws ValidationException
     */
    private function validate(ScheduleProductsStoreData $data): void
    {
        Validator::make($data->toArray(), [
            ...(new ScheduleProductsValidator())->validations($data, 'required'),
        ])->validate();
    }

    private function productsInScheduleRule(ScheduleProductsStoreData $data, Schedule $schedule): void
    {
        $productsIntersect = array_intersect(
            $schedule->products->pluck('product_id')->toArray(),
            array_column($data->products, 'product_id')
        );
        foreach ($productsIntersect as $key => $value) {
            unset($data->products[$key]);
        }
    }

    /**
     * @param ScheduleProductsStoreData $data
     * @param Schedule $schedule
     * @return Collection
     */
    private function addProducts(ScheduleProductsStoreData $data, Schedule $schedule): Collection
    {
        if ($data->products) {
            return $schedule->products()->createMany(
                array_map(
                    function ($row) use ($schedule) {
                        return [...$row, ...['schedule_id' => $schedule->id]];
                    },
                    $data->products
                )
            );
        }
        return $schedule->products;
    }
}