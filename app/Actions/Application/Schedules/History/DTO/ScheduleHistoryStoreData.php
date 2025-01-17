<?php

namespace App\Actions\Application\Schedules\History\DTO;

use Illuminate\Http\Request;
use Spatie\DataTransferObject\DataTransferObject;

class ScheduleHistoryStoreData extends DataTransferObject
{
    public string $type;
    public string $register;
    public ?int $schedule_id;
    public ?int $account_id;

    public static function fromRequest(Request $request): self
    {
        return new self($request->validated());
    }
}