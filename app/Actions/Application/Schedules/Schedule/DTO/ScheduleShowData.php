<?php

namespace App\Actions\Application\Schedules\Schedule\DTO;

use App\Actions\PaginatedDataTransferObject;
use Illuminate\Http\Request;

class ScheduleShowData extends PaginatedDataTransferObject
{
    public static function fromRequest(Request $request): self
    {
        return new self($request->query());
    }
}