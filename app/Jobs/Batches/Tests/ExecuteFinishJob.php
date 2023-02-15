<?php

namespace App\Jobs\Batches\Tests;

use App\Models\Mongodb\BackgroundJobs;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ExecuteFinishJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;
    use Batchable;

    private string $uuid;

    public function __construct(string $uuid)
    {
        $this->uuid = $uuid;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $payloads = BackgroundJobs::query()->where('uuid', '=', $this->uuid)->count();
        BackgroundJobs::query()->create([
            'name' => 'JobFinish',
            'payload' => json_encode([
                'uuid_jobs' => $this->uuid,
                'count_registers' => $payloads
            ]),
            'status' => 'FINISHED'
        ]);
        BackgroundJobs::query()
            ->where('uuid', '=', $this->uuid)
            ->delete();
    }
}
