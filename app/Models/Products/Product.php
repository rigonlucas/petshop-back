<?php

namespace App\Models\Products;

use App\Models\BaseModel;
use App\Models\Users\Account;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $id
 * @property float $cost
 * @property float $price
 */
class Product extends BaseModel
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'type',
        'cost',
        'price',
        'account_id',
        'validate',
    ];

    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }

}
