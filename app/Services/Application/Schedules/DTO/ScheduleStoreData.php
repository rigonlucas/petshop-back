<?php

namespace App\Services\Application\Schedules\DTO;

use App\Http\Requests\Application\Schedule\ScheduleStoreRequest;
use App\Services\Application\Schedules\DTO\Base\ScheduleData;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class ScheduleStoreData extends ScheduleData
{
    public ?array $recurrence = null;
    public ?array $products = null;

    /**
     * @throws UnknownProperties
     */
    public static function fromRequest(ScheduleStoreRequest $request): self
    {
        return new self($request->validated());
    }

    /**
     * @throws UnknownProperties
     */
    public static function fromArray(array $array): self
    {
        return new self($array);
    }
}