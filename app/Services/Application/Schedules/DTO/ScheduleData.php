<?php

namespace App\Services\Application\Schedules\DTO;

use Illuminate\Foundation\Http\FormRequest;
use Spatie\DataTransferObject\Attributes\CastWith;
use Spatie\DataTransferObject\Casters\ArrayCaster;
use Spatie\DataTransferObject\DataTransferObject;

class ScheduleData extends DataTransferObject
{
    public ?int $client_id;
    public ?int $pet_id;
    public ?int $type;
    public ?int $status;
    public ?int $user_id = null;
    public ?string $start_at;
    public ?int $duration;
    public ?string $description = null;
    /** @var \App\Services\Application\Schedules\DTO\ScheduleProductData[] $products */
    #[CastWith(ArrayCaster::class, itemType: ScheduleProductData::class)]
    public ?array $products = null;

    public static function fromRequest(FormRequest $request): self
    {
        $validated = $request->validated();
        clock($validated);
        return (new self($validated))->only(...array_keys($validated));
    }
}