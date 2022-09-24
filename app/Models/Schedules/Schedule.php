<?php

namespace App\Models\Schedules;

use App\Enums\SchedulesStatusEnum;
use App\Models\BaseModel;
use App\Models\Clients\Client;
use App\Models\Clients\Pet;
use App\Models\Clients\PetVaccine;
use App\Models\Products\Product;
use App\Models\ScheduleRecurrence;
use App\Models\User;
use App\Models\Users\Account;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

/**
 * @property int $id
 * @property int $account_id
 * @property int $client_id
 * @property int $pet_id
 * @property int $schedule_recurrence_id
 * @property int $type
 * @property int $status
 * @property int $user_id
 * @property Carbon $start_at
 * @property int $duration
 * @property string $description
 * @property Carbon $updated_at
 * @property Carbon $created_at
 *
 * @property Collection<ScheduleHasProduct> $hasProducts
 * @property Collection<PetVaccine> $hasVaccines
 */
class Schedule extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        "account_id",
        "client_id",
        "pet_id",
        "schedule_recurrence_id",
        "type",
        "status",
        "user_id",
        "start_at",
        "duration",
        "description",
    ];

    protected $casts = [
        'start_at' => 'datetime:Y-m-d'
    ];

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }
    public function pet(): BelongsTo
    {
        return $this->belongsTo(Pet::class);
    }

    public function hasProducts(): HasMany
    {
        return $this->hasMany(ScheduleHasProduct::class);
    }

    public function hasVaccines(): HasMany
    {
        return $this->hasMany(PetVaccine::class);
    }

    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function recurrenceGroup(): BelongsTo
    {
        return $this->belongsTo(
            ScheduleRecurrence::class,
            'schedule_recurrence_id',
            'id'
        );
    }
}
