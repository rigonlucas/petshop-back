<?php

namespace App\Models\Products;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductPrice extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'cost_price',
        'price'
    ];
}
