<?php

namespace App\Jobs\Schedules;

use App\Enums\SchedulesStatusEnum;
use App\Models\User;
use App\Services\Application\Exports\Schedules\SchedulesStatusExportService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SchedulesExportJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private SchedulesStatusExportService $service;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(private readonly User $user, private readonly SchedulesStatusEnum $enum)
    {
    }

    /**
     * Execute the job.
     *
     * @param SchedulesStatusExportService $service
     * @return void
     */
    public function handle(SchedulesStatusExportService $service): void
    {
        $service->export($this->user, $this->enum);
    }
}
