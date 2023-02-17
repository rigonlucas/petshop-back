<?php

namespace App\Jobs\Batches\Entities;

use App\Enums\Exports\StorageExportEnum;
use App\Models\Mongodb\ExportsJob;
use App\Notifications\Export\ExportFinishedNotify;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use ZipArchive;

class CompactExportsFinishJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;
    use Batchable;

    private string $basePath;
    private string $title = 'Zip dos arquivos exportados';

    public function __construct(private string $uuid, private readonly Model $user)
    {
        $this->basePath = storage_path() . '/app/' . StorageExportEnum::PRIVATE_DISK->value . '/';
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $zipFile = StorageExportEnum::COMPACT_FILE_NAME_BASE->getFileName();
        $generatedPath = StorageExportEnum::COMPACT_FILE_PATH->getPath($this->user->account->uuid);
        $path = $this->basePath . $generatedPath;

        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }

        $fullFilePath = $path . $zipFile . '.zip';
        $zip = new ZipArchive();

        if ($zip->open($fullFilePath, ZipArchive::CREATE) === true) {
            $files = ExportsJob::query()->where('uuid', '=', $this->uuid)->get();
            foreach ($files as $file) {
                if ($file) {
                    $zip->addFile(
                        Storage::disk($file->payload['disk'])
                            ->path($file->payload['path'] . $file->payload['file_name']),
                        $file->payload['file_name']
                    );
                }
            }
        }
        $zip->close();

        $url = Storage::disk(StorageExportEnum::PRIVATE_DISK->value)->temporaryUrl(
            $generatedPath . $zipFile . '.zip',
            now()->addDays(5)
        );

        Notification::route('mail', $this->user->email)
            ->notify(new ExportFinishedNotify($this->uuid, $this->user, $url));

        $payload = ExportsJob::query()
            ->select('_id', 'name', 'file_type')
            ->where('uuid', '=', $this->uuid)
            ->get()
            ->toArray();

        ExportsJob::query()->create([
            'name' => $this->title,
            'status' => 'FINISHED',
            'finish_job' => true,
            'payload' => $payload,
            'uuid' => $this->uuid,
            'user_id' => $this->user->id,
            'main' => true,
            'file_type' => 'zip',
            'account_id' => $this->user->account_id,
            'finished_at' => now()
        ]);
    }
}
