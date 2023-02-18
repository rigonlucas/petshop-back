<?php

namespace App\Actions\Application\Pets\Vaccines\DTO;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Spatie\DataTransferObject\DataTransferObject;

class PetVaccineStoreData extends DataTransferObject
{
    public ?string $schedule_id = null;
    public int $pet_id;
    public int $client_id;
    public int $vaccine_id;
    public bool $applied;
    public string|Carbon|null $applied_at = null;
    public bool $schedule_new;
    public string|Carbon|null $schedule_date = null;

    public static function fromRequest(Request $request): self
    {
        return new self($request->validated());
    }
}