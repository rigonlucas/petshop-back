<?php

namespace App\Jobs\Batches\Entities;

use App\Enums\Exports\StatusJobEnum;
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
use MongoDB\BSON\UTCDateTime;
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
    private mixed $jobs;

    public function __construct(private string $uuid, private readonly Model $user, private readonly bool $hasFailures)
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
        $this->jobs = ExportsJob::query()
            ->select('_id', 'name', 'file_type', 'payload')
            ->where('uuid', '=', $this->uuid)
            ->toBase()
            ->get();
        if ($this->hasFailures) {
            $this->deleteFiles();
            $this->updateFailedJob();
            return;
        }
        $zipFile = StorageExportEnum::COMPACT_FILE_NAME_BASE->getFileName();
        $generatedPath = StorageExportEnum::COMPACT_FILE_PATH->getPath($this->user->account->uuid);
        $path = $this->basePath . $generatedPath;

        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }

        $fullFilePath = $path . $zipFile . '.zip';
        $zip = new ZipArchive();

        if ($zip->open($fullFilePath, ZipArchive::CREATE) === true) {
            $files = ExportsJob::query()
                ->whereNull('main')
                ->where('uuid', '=', $this->uuid)->get();
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

        $zipExpires = now()->addDays(10);
        $url = Storage::disk(StorageExportEnum::PRIVATE_DISK->value)->temporaryUrl(
            $generatedPath . $zipFile . '.zip',
            $zipExpires
        );

        Notification::route('mail', $this->user->email)
            ->notify(new ExportFinishedNotify($this->uuid, $this->user, $url));

        $exportedFiles = $this->deleteFiles();

        $payloadZip = [
            'path' => $path,
            'file_name' => $zipFile . '.zip',
            'disk' => StorageExportEnum::PRIVATE_DISK->value,
        ];

        ExportsJob::query()
            ->create([
                'name' => $this->title,
                'status' => StatusJobEnum::FINISHED->value,
                'payload' => $payloadZip,
                'temporary_url' => [
                    'url' => $url,
                    'expires_at' => new UTCDateTime($zipExpires)
                ],
                'file_group' => $exportedFiles,
                'uuid' => $this->uuid,
                'user_id' => $this->user->id,
                'main' => true,
                'file_type' => 'zip',
                'has_error' => false,
                'account_id' => $this->user->account_id,
                'finished_at' => new UTCDateTime(now())
            ]);
    }

    public function failed($exception = null)
    {
        $this->updateFailedJob();
        $this->deleteFiles();
    }

    /**
     * @return array
     */
    public function deleteFiles(): array
    {
        $exportedFiles = [];
        foreach ($this->jobs as $job) {
            $payload = $job['payload'];
            if (isset($payload)) {
                $wasDeleted = Storage::disk($payload['disk'])
                    ->delete($payload['path'] . $payload['file_name']);
                if ($wasDeleted) {
                    $exportedFiles [] = [
                        'name' => $job['name'],
                        'file_name' => $payload['file_name']
                    ];
                    ExportsJob::query()->where('_id', '=', $job['_id'])->delete();
                }
            }
        }
        return $exportedFiles;
    }

    /**
     * @return void
     */
    public function updateFailedJob(): void
    {
        ExportsJob::query()
            ->create([
                'name' => $this->title,
                'status' => StatusJobEnum::ERROR->value,
                'uuid' => $this->uuid,
                'user_id' => $this->user->id,
                'main' => true,
                'has_error' => true,
                'file_type' => 'error',
                'account_id' => $this->user->account_id,
                'finished_at' => new UTCDateTime(now())
            ]);
    }
}
