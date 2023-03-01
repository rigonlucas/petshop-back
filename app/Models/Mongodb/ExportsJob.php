<?php

namespace App\Models\Mongodb;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class ExportsJob extends Eloquent
{
    protected $connection = 'mongodb';
    protected $collection = 'exports_jobs';

    protected $fillable = [
        'user_id',
        'account_id',
        'name',
        'uuid',
        'payload',
        'temporary_url',
        'has_error',
        'status',
        'file_group',
        'file_type',
        'main',
        'finished_at',
        'errors'
    ];
}
