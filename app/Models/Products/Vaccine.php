<?php

namespace App\Models\Products;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @property int $id
 * @property string $name
 * @property string $description
 * @property int $type
 * @property int $number_first_shoot
 * @property int $number_first_shoot_days
 * @property int $days_to_booster_dose
 */
class Vaccine extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'type',
    ];
}
