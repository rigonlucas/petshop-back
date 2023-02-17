<?php

namespace App\Http\Controllers\Jobs\Tests;

use App\Enums\SchedulesStatusEnum;
use App\Http\Controllers\Controller;
use App\Jobs\Batches\Entities\CompactExportsFinishJob;
use App\Jobs\Batches\Entities\ExportProductsJob;
use App\Jobs\Batches\Entities\ExportSchedulesJob;
use App\Models\User;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Str;

class JobTestController extends Controller
{
    public function test_batches()
    {
        $uuid = Str::uuid();
        $user = User::query()->with('account:id,uuid')->first();

        $jobs = [
            new ExportProductsJob($uuid, $user),
            new ExportSchedulesJob($uuid, $user, SchedulesStatusEnum::EXECUTING)
        ];
        Bus::batch($jobs)
            ->finally(function () use ($uuid, $user) {
                CompactExportsFinishJob::dispatch($uuid, $user);
            })
            ->dispatch();
        return view('job-test');
    }
}
