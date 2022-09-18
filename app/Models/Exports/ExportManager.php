<?php

namespace App\Models\Exports;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int account_id
 * @property string $model_type
 * @property string $path
 */
class ExportManager extends Model
{
    use HasFactory;

    public const UPDATED_AT = null;
}
