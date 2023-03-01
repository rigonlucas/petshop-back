<?php

namespace App\Http\Controllers\Accounts\Managers;

use App\Http\Controllers\Controller;
use App\Jobs\Batches\Entities\CompactExportsFinishJob;
use App\Jobs\Batches\Entities\ExportProductsJob;
use App\Jobs\Batches\Entities\ExportSchedulesJob;
use App\Models\Mongodb\ExportsJob;
use App\Models\User;
use Illuminate\Bus\Batch;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Bus;

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

    public function exportAll(): JsonResponse
    {
        $user = User::query()->with('account:id,uuid')->first();

        $jobs = [
            new ExportProductsJob($user),
            new ExportSchedulesJob($user)
        ];
        Bus::batch($jobs)
            ->finally(function (Batch $batch) use ($user) {
                dispatch(new CompactExportsFinishJob($batch->id, $user, $batch->hasFailures()));
            })
            ->dispatch();
        return response()->json();
    }
}
