<?php

namespace App\Models\Clients;

use App\Models\BaseModel;
use App\Models\Products\Vaccine;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $vaccine_id
 * @property int $pet_id
 * @property int|null $schedule_id
 * @property bool $applied
 * Relations:
 * @property Pet $pet
 * @property Vaccine $vaccine
 */
class PetVaccine extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'vaccine_id',
        'pet_id',
        'schedule_id',
        'applied'
    ];

    public function vaccine(): BelongsTo
    {
        return $this->belongsTo(Vaccine::class);
    }

    public function pet(): BelongsTo
    {
        return $this->belongsTo(Pet::class);
    }
}
