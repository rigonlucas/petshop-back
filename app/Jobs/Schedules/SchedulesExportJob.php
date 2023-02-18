<?php

namespace App\Jobs\Schedules;

use App\Actions\Application\Exports\Schedules\SchedulesStatusExportAction;
use App\Enums\SchedulesStatusEnum;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SchedulesExportJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private SchedulesStatusExportAction $service;

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
     * @param SchedulesStatusExportAction $service
     * @return void
     */
    public function handle(SchedulesStatusExportAction $service): void
    {
        $service->export($this->user, $this->enum);
    }
}
