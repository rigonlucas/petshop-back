<?php

namespace App\Models;

use App\Enums\SchedulesStatusEnum;
use App\Models\Scopes\ByAccount;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $id
 *
 * @method static Builder openSchedule
 */
class Schedule extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        "account_id",
        "client_id",
        "pet_id",
        "type",
        "status",
        "user_id",
        "start_at",
        "duration",
        "description",
    ];

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::addGlobalScope(new ByAccount());
    }

    /**
     * @param Builder $query
     * @return Builder
     */
    public function scopeOpenSchedule(Builder $query): Builder
    {
        return $query->where('status', '=', SchedulesStatusEnum::OPEN);
    }


    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function pet(): BelongsTo
    {
        return $this->belongsTo(Pet::class);
    }

    public function account (): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }

    public function user (): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
