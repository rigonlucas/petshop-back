<?php

namespace App\Rules\Schedule;

use App\Models\Schedule\Schedule;
use Carbon\Carbon;
use Illuminate\Contracts\Validation\Rule;

class CanBookAScheduleRule implements Rule
{
    public function __construct(private int $userId, private int $duration)
    {
    }

    public function passes($attribute, $value): bool
    {
        $startAt = Carbon::create($value);
        $finishAt = Carbon::create($value)->addMinutes($this->duration);
        return !Schedule::query()
            ->where('user_id', '=', $this->userId)
            ->whereBetween('start_at', [$startAt, $finishAt])
            ->exists();
    }

    public function message()
    {
        return 'Conflito de horários';
    }
}
