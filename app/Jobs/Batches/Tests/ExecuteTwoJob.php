<?php

namespace App\Jobs\Batches\Tests;

use App\Models\Mongodb\BackgroundJobs;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ExecuteTwoJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;
    use Batchable;

    private string $uuid;

    /**
     * Create a new job instance.
     *
     * @return void
     */
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
        BackgroundJobs::query()->create([
            'name' => 'JobTwo',
            'payload' => json_encode([
                'method' => __METHOD__ . rand(0, 10000)
            ]),
            'uuid' => $this->uuid
        ]);
    }
}
