<?php

namespace App\Services\Application\Schedules\DTO;

use App\Services\PaginatedDataTransferObject;
use Illuminate\Http\Request;

class ScheduleShowData extends PaginatedDataTransferObject
{
    public static function fromRequest(Request $request): self
    {
        return new self($request->query());
    }
}