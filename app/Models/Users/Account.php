<?php

namespace App\Models\Users;

use App\Models\BaseModel;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $id;
 * @property string $uuid;
 * @property string $name;
 * @property string $account_users;
 */
class Account extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'name',
        'expire_at',
        'user_id'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }
}
