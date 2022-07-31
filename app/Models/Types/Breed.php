<?php

namespace App\Models\Types;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Breed extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'account_id',
        'client_id',
        'breed_id',
        'name',
        'birthday'
    ];

    protected $casts = [
        'date' => 'birthday'
    ];
}
