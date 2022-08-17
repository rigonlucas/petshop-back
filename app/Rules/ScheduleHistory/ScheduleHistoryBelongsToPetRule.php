<?php

namespace App\Rules\ScheduleHistory;

use App\Models\Schedules\ScheduleHistory;
use Illuminate\Contracts\Validation\Rule;

class ScheduleHistoryBelongsToPetRule implements Rule
{
    public function __construct(private readonly int $scheduleHistoryId)
    {
        //
    }

    public function passes($attribute, $value)
    {
        return ScheduleHistory::query()
            ->where('id', '=', $this->scheduleHistoryId)
            ->where('schedule_id', '=', $value)
            ->exists();
    }

    public function message()
    {
        return 'Registro não encontrado';
    }
}
