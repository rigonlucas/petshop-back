<?php

namespace App\Models\Clients;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @property int $id
 * @property int $vaccine_id
 * @property int $pet_id
 * @property int|null $schedule_id
 * @property bool $applied
 * Relations:
 * @property Pet $pet
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
}
