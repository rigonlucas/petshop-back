<?php

namespace App\Http\Controllers\Jobs\Tests;

use App\Http\Controllers\Controller;
use App\Http\Middleware\LimitRequests;
use App\Jobs\Batches\Entities\CompactExportsFinishJob;
use App\Jobs\Batches\Entities\ExportProductsJob;
use App\Jobs\Batches\Entities\ExportSchedulesJob;
use App\Models\User;
use Illuminate\Bus\Batch;
use Illuminate\Support\Facades\Bus;

class JobTestController extends Controller
{
    public function test_batches()
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
        return view('job-test');
    }
}
