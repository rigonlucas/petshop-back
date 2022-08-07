<?php

namespace App\Models;

use App\Models\Schedules\Schedule;
use App\Models\Users\Account;
use App\Traits\BitwiseFlagsTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * @property int $id
 * @property int account_id
 *
 * @method static Builder byAccount(int $clientId)
 */
class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use SoftDeletes;
    use Notifiable;
    use BitwiseFlagsTrait;

    const FLAG_ACTIVE = 2 ** 0;
    const FLAG_EMAIL_VERIFIED = 2 ** 1;
    const FLAG_BLOCKED = 2 ** 3;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'account_id',
        'phone'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function scopeByAccount(Builder $query, int $accountId): Builder
    {
        return $query->where('account_id', '=', $accountId);
    }


    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }

    public function schedules(): HasMany
    {
        return $this->hasMany(Schedule::class);
    }
}
