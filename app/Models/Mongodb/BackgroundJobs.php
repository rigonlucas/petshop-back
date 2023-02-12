<?php

namespace App\Models\Mongodb;


use Jenssegers\Mongodb\Eloquent\Model;

class BackgroundJobs extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'background_jobs';

    protected $fillable = [
        'user_id',
        'account_id',
        'name',
        'status',
        'created_at',
        'process_start_at',
        'finished_at',
        'errors'
    ];
}
