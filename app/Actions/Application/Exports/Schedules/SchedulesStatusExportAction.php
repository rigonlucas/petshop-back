<?php

namespace App\Actions\Application\Exports\Schedules;

use App\Actions\BaseAction;
use App\Actions\Interfaces\Export\ExportInterface;
use App\Enums\Exports\ExportConfigEnum;
use App\Enums\Exports\StorageExportEnum;
use App\Enums\SchedulesStatusEnum;
use App\Enums\SchedulesTypesEnum;
use App\Models\User;
use App\Repository\Application\Exports\Schedules\SchedulesByStatusRepository;
use App\Repository\interfaces\ExportQueryInterface;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class SchedulesStatusExportAction extends BaseAction implements ExportInterface
{
    private array $header_args = [
        'id do agendamento',
        'client_id',
        'client_name',
        'client_phone',
        'pet_id',
        'pet_name',
        'user_id',
        'user_name',
        'type',
        'status',
        'start_at',
        'duration',
        'finish_at'
    ];

    public function export(User $user, ?SchedulesStatusEnum $enumStatus): array
    {
        $schedulesQuery = new SchedulesByStatusRepository($user, $enumStatus);
        $output = $this->setHeaders();
        $output = $this->createFile($schedulesQuery, $output);
        return $this->getFileGenerator($user, $output);
    }

    public function setHeaders(): mixed
    {
        $output = fopen('php://temp/maxmemory:' . ExportConfigEnum::MEMORY_MAX_CSV->value, 'r+');

        if (ob_get_contents()) {
            ob_end_clean();
        }

        fputcsv($output, $this->header_args);

        return $output;
    }

    public function createFile(ExportQueryInterface $exportQuery, mixed $output): mixed
    {
        foreach ($exportQuery->getQuery()->cursor() as $schedule) {
            $dados = [
                'id do agendamento' => $schedule->id,
                'client_id' => $schedule->client_id,
                'client_name' => $schedule->client_name,
                'client_phone' => $schedule->client_phone,
                'pet_id' => $schedule->pet_id,
                'pet_name' => $schedule->pet_name,
                'user_id' => $schedule->user_id,
                'user_name' => $schedule->user_name,
                'type' => SchedulesTypesEnum::from($schedule->type)->name,
                'status' => SchedulesStatusEnum::from($schedule->status)->name,
                'start_at' => Carbon::createFromFormat('Y-m-d H:i:s', $schedule->start_at)->format('d/m/Y H:i:s'),
                'duration' => $schedule->duration,
                'finish_at' => Carbon::createFromFormat('Y-m-d H:i:s', $schedule->finish_at)->format('d/m/Y H:i:s'),
            ];
            fputcsv($output, $dados);
        }
        return $output;
    }

    public function getFileGenerator(User $user, mixed $output): array
    {
        $zipFile = StorageExportEnum::SCHEDULES_FILE_NAME_BASE->getFileName();
        $path = StorageExportEnum::SCHEDULES_PATH->getPath($user->account->uuid);

        Storage::disk(StorageExportEnum::PRIVATE_DISK->value)->put(
            $path . $zipFile . '.csv',
            $output
        );
        fclose($output);

        return [
            'path' => $path,
            'file_name' => $zipFile . '.csv',
            'disk' => StorageExportEnum::PRIVATE_DISK->value
        ];
    }
}