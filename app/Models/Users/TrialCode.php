<?php

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrialCode extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'token'
    ];
}
