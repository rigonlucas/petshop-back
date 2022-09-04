<?php

namespace App\Services\Application\Schedules\DTO;

use App\Http\Requests\Application\Schedule\ScheduleStoreRequest;
use App\Services\Application\Schedules\DTO\Base\ScheduleBaseData;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class ScheduleStoreData extends ScheduleBaseData
{
    public ?array $recurrence = null;
    public ?array $products = null;
    public ?int $schedule_recurrence_id = null;
    /**
     * @throws UnknownProperties
     */
    public static function fromRequest(ScheduleStoreRequest $request): self
    {
        return new self($request->validated());
    }
}