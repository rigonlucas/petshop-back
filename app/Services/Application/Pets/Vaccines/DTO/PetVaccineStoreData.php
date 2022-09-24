<?php

namespace App\Services\Application\Pets\Vaccines\DTO;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Spatie\DataTransferObject\DataTransferObject;

class PetVaccineStoreData extends DataTransferObject
{
    public ?string $schedule_id = null;
    public int $pet_id;
    public int $vaccine_id;
    public bool $applied;
    public string|Carbon|null $applied_at = null;

    public static function fromRequest(Request $request): self
    {
        return new self($request->validated());
    }
}