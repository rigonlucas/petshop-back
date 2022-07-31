<?php

namespace App\Models\Clients;

use App\Models\BaseModel;
use App\Models\Scopes\ByAccount;
use App\Models\Types\Breed;
use App\Models\Users\Account;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $id
 *
 * @method static Builder tutor(int $clientId)
 */
class Pet extends BaseModel
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'client_id',
        'account_id',
        'breed_id',
        'name',
        'birthday'
    ];

    public function scopeTutor(Builder $query, int $clientId): Builder
    {
        return $query->where('client_id', '=', $clientId);
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }

    public function breed(): BelongsTo
    {
        return $this->belongsTo(Breed::class);
    }
}
