<?php

namespace App\Http\Controllers\Accounts\Managers;

use App\Http\Controllers\Controller;
use App\Models\Mongodb\ExportsJob;
use Illuminate\Contracts\Pagination\Paginator;

class ExportsManagerController extends Controller
{
    public function myExports(): Paginator
    {
        return ExportsJob::query()
            ->select(
                '_id',
                'name',
                'file_type',
                'has_error',
                'file_group',
                'temporary_url',
                'uuid',
                'created_at',
                'finished_at'
            )
            ->where('main', '=', true)
            ->where('user_id', '=', auth()->id())
            ->orderByDesc('created_at')
            ->simplePaginate(10);
    }
}
