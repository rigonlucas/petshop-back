<?php

namespace App\Models;

use App\Models\Scopes\ByAccount;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pet extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::addGlobalScope(new ByAccount());
    }

    public function client (): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function account (): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }

    public function breed (): BelongsTo
    {
        return $this->belongsTo(Breed::class);
    }
}
