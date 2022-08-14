<?php

namespace App\Rules\Schedule;

use App\Helpers\BuilderHelper;
use App\Models\Schedules\Schedule;
use Carbon\Carbon;
use Illuminate\Contracts\Validation\Rule;

class CanUpdateAScheduleRule implements Rule
{
    public function __construct(
        private readonly int $scheduleId,
        private readonly int $userId,
        private readonly int $duration
    ) {
    }

    public function passes($attribute, $value): bool
    {
        $startAt = Carbon::create($value);
        $finishAt = Carbon::create($value)->addMinutes($this->duration);
        return BuilderHelper::overlap(Schedule::query(), 'start_at', 'finish_at', $startAt, $finishAt)
            ->where('id', '!=', $this->scheduleId)
            ->where('user_id', '=', $this->userId)
            ->doesntExist();
    }

    public function message()
    {
        return 'Conflito de horários';
    }
}
