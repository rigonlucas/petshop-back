<?php

namespace App\Models\Schedules;

use App\Models\Products\Product;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $product_id
 * @property int $schedule_id
 * @property int $quantity
 * @property float $price
 * @property float $final_price
 * @property float $discount
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
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
