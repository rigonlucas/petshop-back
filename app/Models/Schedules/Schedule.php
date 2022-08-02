<?php

namespace App\Models\Schedules;

use App\Enums\SchedulesStatusEnum;
use App\Models\Clients\Client;
use App\Models\Clients\Pet;
use App\Models\User;
use App\Models\Users\Account;
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
