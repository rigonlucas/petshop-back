<?php

namespace App\Jobs\Products;

use App\Models\User;
use App\Services\Application\Exports\Products\ProductsExportService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUniqueUntilProcessing;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProductsExportJob implements ShouldQueue, ShouldBeUniqueUntilProcessing
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(private readonly User $user)
    {
    }

    /**
     * Execute the job.
     *
     * @param ProductsExportService $service
     * @return void
     */
    public function handle(ProductsExportService $service): void
    {
        $service->export($this->user);
    }

    public function uniqueId()
    {
        return $this->user->id;
    }
}
