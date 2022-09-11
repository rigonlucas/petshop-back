<?php

namespace App\Services\Application\Schedules\DTO\Base;

use Illuminate\Foundation\Http\FormRequest;
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
    public ?array $recurrence = null;
    public ?array $products = null;

    public static function fromRequest(FormRequest $request): self
    {
        $validated = $request->validated();
        return (new self($validated))->only(...array_keys($validated));
    }
}