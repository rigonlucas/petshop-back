<?php

namespace App\Models;

use App\Models\Scopes\ByAccount;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory;
    use SoftDeletes;

    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }
}
