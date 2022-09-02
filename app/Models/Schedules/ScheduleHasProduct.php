<?php

namespace App\Models\Schedules;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScheduleHasProduct extends Model
{
    use HasFactory;

    protected $table = 'schedules_has_products';

    protected $fillable =[
        'product_id',
        'schedule_id',
        'quantity',
        'discount',
        'price'
    ];
}
