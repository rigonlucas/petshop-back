<?php

namespace App\Models\Products;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Vaccine extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'type',
    ];
}
