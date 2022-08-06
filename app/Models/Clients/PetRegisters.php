<?php

namespace App\Models\Clients;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PetRegisters extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'id',
        'register',
        'type'
    ];
}
