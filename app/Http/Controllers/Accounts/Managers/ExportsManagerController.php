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
            ->select('_id', 'name', 'file_group', 'uuid', 'created_at')
            ->where('main', '=', true)
            ->where('user_id', '=', auth()->id())
            ->simplePaginate(10);
    }
}
