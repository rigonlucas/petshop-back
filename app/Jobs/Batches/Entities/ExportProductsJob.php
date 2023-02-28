<?php

namespace App\Jobs\Batches\Entities;

use App\Actions\Application\Exports\Products\ProductsExportAction;
use App\Models\Mongodb\ExportsJob;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUniqueUntilProcessing;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ExportProductsJob implements ShouldQueue, ShouldBeUniqueUntilProcessing
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;
    use Batchable;

    private string $title = 'Exportação de produtos';

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(private readonly Model $user)
    {
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $service = new ProductsExportAction();
        $file = $service->export($this->user);
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
