<?php

namespace App\Services\Application\Schedules\DTO;

use App\Http\Requests\Application\Schedule\ScheduleUpdateRequest;
use App\Services\Application\Schedules\DTO\Base\ScheduleBaseData;
use Spatie\DataTransferObject\DataTransferObject;

class ScheduleUpdateData extends ScheduleBaseData
{
    public ?int $schedule_id = null;

    public static function fromRequest(ScheduleUpdateRequest $request): self
    {
        return new self($request->validated());
    }
}