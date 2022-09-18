<?php

namespace App\Repository\Application\Exports\Schedules;

use App\Enums\SchedulesStatusEnum;
use App\Models\User;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;

class SchedulesByStatusRepository
{
    private Builder $query;

    public function __construct(User $user, SchedulesStatusEnum $enumStatus)
    {
        $this->query = DB::table('schedules')
            ->select([
                'schedules.id',
                'schedules.account_id',
                'schedules.client_id',
                'schedules.user_id',
                'schedules.pet_id',
                'schedules.type',
                'schedules.status',
                'schedules.start_at',
                'schedules.duration',
                'schedules.finish_at',
                'pets.name as pet_name',
                'clients.name as client_name',
                'clients.phone as client_phone',
                'users.name as user_name',
            ])
            ->addSelect(DB::raw('count(schedules_has_products.id) as products_schedule_count'))
            ->leftJoin(
                'schedules_has_products',
                'schedules.id',
                '=',
                'schedules_has_products.schedule_id'
            )
            ->join('pets', 'schedules.pet_id', '=', 'pets.id')
            ->join('clients', 'schedules.client_id', '=', 'clients.id')
            ->leftJoin('users', 'schedules.user_id', '=', 'users.id')
            ->where('schedules.account_id', '=', $user->account_id)
            ->where('schedules.status', '=', $enumStatus->value)
            ->groupBy('schedules.id');
    }

    public function getQuery()
    {
        return $this->query;
    }
}