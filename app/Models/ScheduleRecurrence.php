<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $type
 * @property int $account_id
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class ScheduleRecurrence extends Model
{
    use HasFactory;
    protected $fillable = [
        'type'
    ];
}
