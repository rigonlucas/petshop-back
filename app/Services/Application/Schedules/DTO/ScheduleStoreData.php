<?php

namespace App\Services\Application\Schedules\DTO;

use App\Http\Requests\Application\Schedule\ScheduleStoreRequest;
use Carbon\Carbon;
use Spatie\DataTransferObject\DataTransferObject;

class ScheduleStoreData extends DataTransferObject
{
    public int $client_id;
    public int $pet_id;
    public ?int $account_id;
    public int $type;
    public int $status;
    public ?int $user_id = null;
    public Carbon $start_at;
    public ?Carbon $finish_at;
    public int $duration;
    public ?string $description = null;

    public static function fromRequest(ScheduleStoreRequest $request): self
    {
        return new self($request->validated());
    }
}