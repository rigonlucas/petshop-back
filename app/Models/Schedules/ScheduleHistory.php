<?php

namespace App\Models\Schedules;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ScheduleHistory extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'id',
        'register',
        'type',
        'schedule_id'
    ];
}
