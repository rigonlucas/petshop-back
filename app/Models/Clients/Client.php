<?php

namespace App\Models\Clients;

use App\Models\BaseModel;
use App\Models\Schedules\Schedule;
use App\Models\Users\Account;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Ramsey\Collection\Collection;

/**
 * @property int $id
 *
 * Relations:
 * @property Account $account
 * @property Collection|Pet[] $pets
 */
class Client extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'account_id',
        'name',
        'email',
        'phone'
    ];

    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }

    public function pets(): HasMany
    {
        return $this->hasMany(Pet::class, 'client_id', 'id');
    }

    public function schedules(): HasMany
    {
        return $this->hasMany(Schedule::class);
    }
}
