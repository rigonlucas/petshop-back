<?php

namespace App\Jobs\Batches\Entities;

use App\Actions\Application\Exports\Schedules\SchedulesStatusExportAction;
use App\Enums\SchedulesStatusEnum;
use App\Models\Mongodb\ExportsJob;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUniqueUntilProcessing;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ExportSchedulesJob implements ShouldQueue, ShouldBeUniqueUntilProcessing
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;
    use Batchable;

    private string $title = 'Exportação de agendamentos';

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(
        private readonly Model $user,
        private readonly ?SchedulesStatusEnum $enum = null
    ) {
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $service = new SchedulesStatusExportAction();
        $file = $service->export($this->user, $this->enum);
        ExportsJob::query()->create([
            'name' => $this->title,
            'payload' => $file,
            'uuid' => $this->batchId,
            'user_id' => $this->user->id,
            'account_id' => $this->user->account_id,
            'file_type' => 'csv',
        ]);
    }

    public function uniqueId()
    {
        return $this->user->id;
    }
}
