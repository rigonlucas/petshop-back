<?php

namespace App\Services\Application\Schedules\Schedule\DTO;

use Illuminate\Foundation\Http\FormRequest;
use Spatie\DataTransferObject\DataTransferObject;

class VaccineData extends DataTransferObject
{
    public ?bool $applied;
    public ?int $vaccine_id;

    public static function fromRequest(FormRequest $request): self
    {
        $validated = $request->validated();
        return (new self($validated))->only(...array_keys($validated));
    }
}