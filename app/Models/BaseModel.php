<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static Builder byAccount(int $clientId)
 */
class BaseModel extends Model
{
    public function scopeByAccount(Builder $query, int $accountId): Builder
    {
        return $query->where('account_id', '=', $accountId);
    }
}