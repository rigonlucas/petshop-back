<?php

namespace App\Services\Application\Schedules\DTO;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Spatie\DataTransferObject\DataTransferObject;

class ScheduleStatusData extends DataTransferObject
{
    public ?int $status;
    public ?int $account_id;
    public ?int $schedule_id;
    public string|Carbon|null $reschedule_date = null;

    public static function fromRequest(FormRequest $request): self
    {
        return new self($request->validated());
    }
}