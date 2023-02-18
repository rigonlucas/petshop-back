<?php

namespace App\Actions\Application\Schedules\Schedule\DTO;

use Illuminate\Foundation\Http\FormRequest;
use Spatie\DataTransferObject\DataTransferObject;

class RecurrenceData extends DataTransferObject
{
    public ?int $duration;
    public ?string $start_at;
    public ?int $user_id;

    public static function fromRequest(FormRequest $request): self
    {
        $validated = $request->validated();
        return (new self($validated))->only(...array_keys($validated));
    }
}