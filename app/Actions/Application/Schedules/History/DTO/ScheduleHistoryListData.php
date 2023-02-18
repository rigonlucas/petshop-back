<?php

namespace App\Actions\Application\Schedules\History\DTO;

use App\Actions\PaginatedDataTransferObject;
use Illuminate\Http\Request;

class ScheduleHistoryListData extends PaginatedDataTransferObject
{
    public ?string $name = null;
    public ?int $schedule_id = null;

    public static function fromRequest(Request $request): self
    {
        return new self($request->query());
    }
}