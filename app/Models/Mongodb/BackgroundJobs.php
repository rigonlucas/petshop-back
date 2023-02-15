<?php

namespace App\Models\Mongodb;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class   BackgroundJobs extends Eloquent
{
    protected $connection = 'mongodb';
    protected $collection = 'background_jobs';

    protected $fillable = [
        'user_id',
        'account_id',
        'name',
        'uuid',
        'payload',
        'status',
        'created_at',
        'process_start_at',
        'finished_at',
        'errors'
    ];
}
