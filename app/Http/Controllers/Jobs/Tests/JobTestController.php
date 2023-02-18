<?php

namespace App\Http\Controllers\Jobs\Tests;

use App\Enums\Exports\StatusJobEnum;
use App\Http\Controllers\Controller;
use App\Jobs\Batches\Entities\CompactExportsFinishJob;
use App\Jobs\Batches\Entities\ExportProductsJob;
use App\Jobs\Batches\Entities\ExportSchedulesJob;
use App\Models\Mongodb\ExportsJob;
use App\Models\User;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Str;

class JobTestController extends Controller
{
    public function test_batches()
    {
        $uuid = Str::uuid();
        $user = User::query()->with('account:id,uuid')->first();
        ExportsJob::query()->create([
            'name' => 'Exportação de arquivos inciada',
            'status' => StatusJobEnum::PROCESSING->value,
            'uuid' => $uuid->toString(),
            'user_id' => $user->id,
            'main' => true,
            'file_type' => 'zip',
            'account_id' => $user->account_id,
        ]);

        $jobs = [
            new ExportProductsJob($uuid, $user),
            new ExportSchedulesJob($uuid, $user)
        ];
        Bus::batch($jobs)
            ->finally(function () use ($uuid, $user) {
                CompactExportsFinishJob::dispatch($uuid, $user);
            })
            ->dispatch();
        return view('job-test');
    }
}
