<?php

namespace App\Models\Schedules;

use App\Models\Products\Product;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
